<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\OrderService as AdminOrderService;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для инициации оплаты заказа.
 * 
 * Что делает:
 * - Проверяет, что заказ можно оплатить (статус cart или pending)
 * - Для MVP: сразу помечает как оплаченный (без реальной интеграции с PSP)
 * - В будущем: создаст сессию оплаты в Stripe/Tinkoff и вернёт payment_url
 * 
 * Примечание: В продакшене здесь будет интеграция с платёжной системой.
 * Сейчас для MVP просто меняем статус на 'paid' и генерируем QR-коды.
 */
class PayController extends Controller
{
    public function __construct(
        private AdminOrderService $adminOrderService
    ) {}
    
    /**
     * Инициирует оплату заказа.
     * 
     * @param int $id ID заказа
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        // Загружаем заказ
        $order = Order::with('tickets')->findOrFail($id);
        
        // Проверяем, что заказ можно оплатить
        if (!in_array($order->status, ['cart', 'pending'])) {
            return response()->json([
                'error' => [
                    'message' => 'Этот заказ нельзя оплатить. Статус: ' . $order->status,
                    'code' => 'ORDER_CANNOT_BE_PAID',
                ],
            ], 422);
        }
        
        // Проверяем, что резерв не истёк
        if ($order->expires_at && $order->expires_at < now()) {
            return response()->json([
                'error' => [
                    'message' => 'Время резерва истекло. Пожалуйста, создайте новый заказ.',
                    'code' => 'RESERVATION_EXPIRED',
                ],
            ], 422);
        }
        
        // Для MVP: сразу помечаем как оплаченный
        // В продакшене здесь будет:
        // 1. Создание сессии оплаты в Stripe/Tinkoff
        // 2. Возврат payment_url для редиректа
        // 3. Webhook обработает подтверждение оплаты
        
        try {
            // Используем существующий сервис из админки для обновления статуса
            // Он сам сгенерирует QR-коды и начислит бонусы
            $this->adminOrderService->updateStatus($order, 'paid');
            
            // Перезагружаем заказ со всеми связями
            $order->refresh();
            $order->load(['tickets.seat.sector', 'tickets.game']);
            
            return response()->json([
                'data' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'paid_at' => $order->paid_at->toIso8601String(),
                    'message' => 'Заказ успешно оплачен. Билеты отправлены на email.',
                    // В будущем здесь будет:
                    // 'payment_url' => 'https://pay.stripe.com/...',
                    // 'payment_session_id' => '...',
                ],
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Ошибка при обработке оплаты: ' . $e->getMessage(),
                    'code' => 'PAYMENT_PROCESSING_ERROR',
                ],
            ], 500);
        }
    }
}


