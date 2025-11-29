<?php

namespace App\Services\Admin;

use App\Models\LoyaltyPoint;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderService
{
    public function updateStatus(Order $order, string $status): Order
    {
        // Обновляем статус заказа
        $order->update(['status' => $status]);
        
        // Обновляем статусы билетов в зависимости от статуса заказа
        switch ($status) {
            case 'cart':
                // Корзина - билеты в резерве
                $order->tickets()->update(['status' => 'reserved']);
                break;
                
            case 'pending':
                // Ожидает оплаты - билеты в резерве
                $order->tickets()->update(['status' => 'reserved']);
                break;
                
            case 'paid':
                // Оплачен - фиксируем дату оплаты и меняем статус билетов
                DB::transaction(function () use ($order) {
                    $order->update(['paid_at' => now()]);
                    $order->tickets()->update(['status' => 'paid']);
                    
                    // Генерируем QR-коды для всех билетов
                    $this->generateQrCodesForTickets($order);
                    
                    // Начисляем бонусные баллы
                    $this->awardLoyaltyPoints($order);
                });
                break;
                
            case 'cancelled':
                // Отменен - отменяем все билеты
                $order->tickets()->update(['status' => 'cancelled']);
                break;
                
            case 'expired':
                // Истек - отменяем все билеты
                $order->tickets()->update(['status' => 'cancelled']);
                break;
        }
        
        // Перезагружаем модель со всеми связями
        return $order->fresh(['tickets', 'user']);
    }

    /**
     * Генерирует QR-коды для всех билетов заказа
     */
    protected function generateQrCodesForTickets(Order $order): void
    {
        foreach ($order->tickets as $ticket) {
            // Создаём директорию, если её нет
            $directory = 'qrcodes';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            // Генерируем уникальное имя файла
            $fileName = "ticket_{$ticket->id}_" . md5($ticket->id . $ticket->created_at) . ".png";
            $filePath = "{$directory}/{$fileName}";

            // Данные для QR-кода (можно изменить на нужный формат)
            $qrData = json_encode([
                'ticket_id' => $ticket->id,
                'order_id' => $order->id,
                'game_id' => $ticket->game_id,
                'seat_id' => $ticket->seat_id,
                'user_id' => $order->user_id,
                'verified_at' => null
            ]);

            // Генерируем QR-код
            $qrCode = QrCode::format('png')
                ->size(300)
                ->margin(1)
                ->errorCorrection('H')
                ->generate($qrData);

            // Сохраняем QR-код
            Storage::disk('public')->put($filePath, $qrCode);

            // Обновляем путь в билете
            $ticket->update(['qr_code_path' => $filePath]);
        }
    }

    /**
     * Начисляет бонусные баллы за оплаченный заказ
     */
    protected function awardLoyaltyPoints(Order $order): void
    {
        // Проверяем, что баллы за этот заказ ещё не начислялись
        $alreadyAwarded = LoyaltyPoint::where('related_order_id', $order->id)->exists();
        if ($alreadyAwarded) {
            return; // Баллы уже начислены - выходим
        }

        // Проверяем, что дата оплаты установлена
        if (!$order->paid_at) {
            return; // Нет даты оплаты - не можем рассчитать баллы
        }

        // Получаем все билеты заказа с информацией об играх
        $tickets = $order->tickets()->with('game')->get();
        
        if ($tickets->isEmpty()) {
            return; // Нет билетов - не начисляем баллы
        }

        // Проверяем, что все билеты относятся к одному матчу
        $uniqueGameIds = $tickets->pluck('game_id')->unique();
        if ($uniqueGameIds->count() > 1) {
            return; // Билеты относятся к разным матчам - не начисляем баллы
        }

        // Получаем игру (все билеты относятся к одному матчу)
        $game = $tickets->first()->game;
        if (!$game) {
            return; // Нет информации о матче - не начисляем баллы
        }

        // Базовый процент начисления
        $percentage = 5;

        // +3% если матч категории derby или playoff
        if (in_array($game->category ?? 'regular', ['derby', 'playoff'])) {
            $percentage += 3;
        }

        // +2% если у пользователя ≥3 оплаченных заказов (исключая текущий)
        $paidOrdersCount = Order::where('user_id', $order->user_id)
            ->where('status', 'paid')
            ->where('id', '!=', $order->id)
            ->count();
        
        if ($paidOrdersCount >= 3) {
            $percentage += 2;
        }

        // +1% если заказ оплачен за 7+ дней до начала матча
        // Используем order.paid_at, а не текущую дату
        $daysUntilGame = $order->paid_at->diffInDays($game->start_at, false);
        if ($daysUntilGame >= 7) {
            $percentage += 1;
        }

        // Максимум 10%
        $percentage = min($percentage, 10);

        // Рассчитываем баллы (округлённое целое)
        $points = (int) round(($order->total_amount * $percentage) / 100);

        // Создаём запись о начислении
        LoyaltyPoint::create([
            'user_id' => $order->user_id,
            'points' => $points,
            'reason' => "Покупка билетов на матч «{$game->title}» ({$percentage}% кэшбэк)",
            'related_order_id' => $order->id,
            'expires_at' => now()->addYear(), // Баллы действуют 1 год
        ]);
    }
}

