<?php

namespace App\Services\Api;

use App\Models\Game;
use App\Models\Order;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

/**
 * Сервис для работы с заказами через API.
 * 
 * Что делает этот класс:
 * - Создаёт заказы с резервированием мест
 * - Проверяет доступность мест
 * - Подсчитывает суммы
 * - Управляет транзакциями (чтобы всё или ничего)
 */
class OrderService
{
    /**
     * Создаёт новый заказ с резервированием мест.
     * 
     * Логика:
     * 1. Проверяем, что матч существует и продажа открыта
     * 2. Проверяем, что все места принадлежат стадиону матча
     * 3. Проверяем, что места не заняты (paid или актуальный reserved)
     * 4. В транзакции создаём заказ и билеты
     * 5. Устанавливаем срок резерва (15 минут)
     * 
     * @param int $gameId ID матча
     * @param array $seatIds Массив ID мест
     * @param int|null $userId ID пользователя (null для гостей)
     * @param string|null $email Email покупателя (для гостей)
     * @param string|null $customerName Имя покупателя
     * @return Order Созданный заказ
     * @throws \Exception Если места заняты или матч недоступен
     */
    public function createOrder(
        int $gameId,
        array $seatIds,
        ?int $userId = null,
        ?string $email = null,
        ?string $customerName = null
    ): Order {
        // Загружаем матч вместе со стадионом
        $game = Game::with('stadium')->findOrFail($gameId);
        
        // Проверяем, что продажа билетов открыта
        // Для MVP полагаемся только на статус матча
        // Если админ поставил статус 'tickets_open' или 'ready', значит продажа открыта
        // В продакшене можно добавить дополнительную проверку даты начала матча
        if (!in_array($game->status, ['tickets_open', 'ready'])) {
            throw new \Exception('Продажа билетов на этот матч закрыта. Статус матча: ' . $game->status);
        }
        
        // Примечание: Проверку даты начала матча убрали для MVP
        // Если нужно, можно добавить позже:
        // if ($game->start_at && $game->start_at <= now()) {
        //     throw new \Exception('Матч уже начался или завершён.');
        // }
        
        // Загружаем все выбранные места вместе с секторами
        $seats = Seat::with('sector')
            ->whereIn('id', $seatIds)
            ->where('is_active', true)
            ->get();
        
        // Проверяем, что все места найдены
        if ($seats->count() !== count($seatIds)) {
            throw new \Exception('Одно или несколько мест не найдены или неактивны.');
        }
        
        // Проверяем, что все места принадлежат стадиону матча
        $invalidSeats = $seats->filter(function ($seat) use ($game) {
            return $seat->sector->stadium_id !== $game->stadium_id;
        });
        
        if ($invalidSeats->isNotEmpty()) {
            throw new \Exception('Одно или несколько мест не принадлежат стадиону этого матча.');
        }
        
        // Проверяем доступность мест (не заняты ли они)
        $this->checkSeatsAvailability($gameId, $seatIds);
        
        // Подсчитываем сумму заказа
        $totalAmount = $seats->sum(function ($seat) {
            return $seat->sector->price_per_seat;
        });
        
        // Всё проверено - создаём заказ в транзакции
        // Транзакция гарантирует: либо всё создаётся, либо ничего (если ошибка)
        return DB::transaction(function () use (
            $gameId,
            $seatIds,
            $userId,
            $email,
            $customerName,
            $totalAmount,
            $seats
        ) {
            // Создаём заказ
            // Примечание: game_id можно получить из билетов, поэтому не храним в orders
            $order = Order::create([
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'currency' => 'RUB',
                'status' => 'cart', // Статус "корзина" - ещё не оплачен
                'expires_at' => now()->addMinutes(15), // Заказ истекает через 15 минут
            ]);
            
            // Создаём билеты для каждого места
            foreach ($seats as $seat) {
                Ticket::create([
                    'order_id' => $order->id,
                    'game_id' => $gameId,
                    'seat_id' => $seat->id,
                    'status' => 'reserved', // Статус "зарезервировано"
                    'reservation_expires_at' => now()->addMinutes(15), // Резерв истекает через 15 минут
                ]);
            }
            
            // Перезагружаем заказ со всеми связями
            // Важно: загружаем tickets с их связями (seat.sector и game)
            // В модели Order нет прямой связи game, поэтому получаем game через tickets
            return $order->load(['tickets.seat.sector', 'tickets.game']);
        });
    }
    
    /**
     * Проверяет доступность мест для матча.
     * 
     * Место считается занятым, если:
     * - Есть билет со статусом 'paid' (оплачен)
     * - Есть билет со статусом 'reserved' и reservation_expires_at > now() (актуальный резерв)
     * 
     * @param int $gameId ID матча
     * @param array $seatIds Массив ID мест
     * @throws \Exception Если хотя бы одно место занято
     */
    protected function checkSeatsAvailability(int $gameId, array $seatIds): void
    {
        // Находим все занятые места для этого матча
        $busySeatIds = Ticket::query()
            ->where('game_id', $gameId)
            ->whereIn('seat_id', $seatIds)
            ->where(function ($q) {
                // Место занято, если билет оплачен
                $q->where('status', 'paid')
                    // или если билет в резерве и резерв ещё не истёк
                    ->orWhere(function ($q2) {
                        $q2->where('status', 'reserved')
                           ->where('reservation_expires_at', '>', now());
                    });
            })
            ->pluck('seat_id')
            ->unique()
            ->all();
        
        // Если есть занятые места - выбрасываем исключение
        if (!empty($busySeatIds)) {
            $busyCount = count($busySeatIds);
            throw new \Exception(
                "Одно или несколько мест уже заняты ({$busyCount} мест). Пожалуйста, выберите другие места."
            );
        }
    }
}

