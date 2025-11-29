<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Контроллер для отмены заказа.
 * 
 * Что делает:
 * - Проверяет, что заказ можно отменить (статус cart или pending)
 * - Отменяет все билеты (освобождает места)
 * - Меняет статус заказа на 'cancelled'
 */
class CancelController extends Controller
{
    /**
     * Отменяет заказ.
     * 
     * @param int $id ID заказа
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        // Загружаем заказ
        $order = Order::with('tickets')->findOrFail($id);
        
        // Проверяем, что заказ можно отменить
        // Нельзя отменить оплаченный заказ (только через админку)
        if ($order->status === 'paid') {
            return response()->json([
                'error' => [
                    'message' => 'Нельзя отменить оплаченный заказ. Обратитесь в поддержку.',
                    'code' => 'ORDER_ALREADY_PAID',
                ],
            ], 422);
        }
        
        // Проверяем, что заказ не уже отменён
        if (in_array($order->status, ['cancelled', 'expired'])) {
            return response()->json([
                'error' => [
                    'message' => 'Заказ уже отменён.',
                    'code' => 'ORDER_ALREADY_CANCELLED',
                ],
            ], 422);
        }
        
        // Отменяем заказ в транзакции
        DB::transaction(function () use ($order) {
            // Меняем статус заказа
            $order->update(['status' => 'cancelled']);
            
            // Отменяем все билеты (освобождаем места)
            // Когда билет отменён, место снова становится доступным
            $order->tickets()->update(['status' => 'cancelled']);
        });
        
        // Перезагружаем заказ
        $order->refresh();
        
        return response()->json([
            'data' => [
                'id' => $order->id,
                'status' => $order->status,
                'message' => 'Заказ успешно отменён. Места освобождены.',
            ],
        ]);
    }
}


