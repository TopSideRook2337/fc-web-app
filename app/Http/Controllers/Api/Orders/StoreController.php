<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Orders\StoreRequest;
use App\Services\Api\OrderService;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для создания заказа (корзины).
 * 
 * Что делает:
 * - Принимает данные от фронтенда (game_id, seats, email)
 * - Валидирует через StoreRequest
 * - Вызывает сервис для создания заказа
 * - Возвращает созданный заказ с таймером резерва
 */
class StoreController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Создаёт новый заказ с резервированием мест.
     * 
     * @param StoreRequest $request Валидированные данные
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request): JsonResponse
    {
        // Принудительно устанавливаем, что это API-запрос
        // Это гарантирует, что Laravel вернёт JSON, а не HTML
        $request->headers->set('Accept', 'application/json');
        
        try {
            // Получаем валидированные данные
            $validated = $request->validated();
            
            // Получаем ID пользователя (если авторизован)
            // Для MVP может быть null (гостевой заказ)
            $userId = $request->user()?->id;
            
            // Создаём заказ через сервис
            // Сервис сам проверит доступность мест и создаст всё в транзакции
            $order = $this->orderService->createOrder(
                gameId: $validated['game_id'],
                seatIds: $validated['seats'],
                userId: $userId,
                email: $validated['email'] ?? null,
                customerName: $validated['customer_name'] ?? null
            );
            
            // Подсчитываем, сколько секунд осталось до истечения резерва
            $secondsUntilExpiry = $order->expires_at 
                ? max(0, now()->diffInSeconds($order->expires_at, false))
                : 0;
            
            // Формируем ответ для фронтенда
            return response()->json([
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'total_amount' => (float) $order->total_amount,
                    'currency' => $order->currency,
                    'expires_at' => $order->expires_at?->toIso8601String(),
                    'reservation_seconds_left' => $secondsUntilExpiry, // Сколько секунд осталось
                    'tickets' => $order->tickets->map(function ($ticket) {
                        return [
                            'id' => $ticket->id,
                            'seat_id' => $ticket->seat_id,
                            'row' => $ticket->seat->row,
                            'number' => $ticket->seat->number,
                            'sector' => $ticket->seat->sector->name,
                            'price' => (float) $ticket->seat->sector->price_per_seat,
                            'status' => $ticket->status,
                            'reservation_expires_at' => $ticket->reservation_expires_at?->toIso8601String(),
                        ];
                    }),
                    'game' => [
                        'id' => $order->tickets->first()->game_id,
                        'title' => $order->tickets->first()->game->title ?? null,
                        'start_at' => $order->tickets->first()->game->start_at?->toIso8601String(),
                    ],
                ],
                'meta' => [
                    'message' => 'Заказ успешно создан. Места зарезервированы на 15 минут.',
                ],
            ], 201); // HTTP 201 Created
            
        } catch (\Exception $e) {
            // Если произошла ошибка (места заняты, матч недоступен и т.д.)
            return response()->json([
                'error' => [
                    'message' => $e->getMessage(),
                    'code' => 'ORDER_CREATION_FAILED',
                ],
            ], 422); // HTTP 422 Unprocessable Entity
        }
    }
}
