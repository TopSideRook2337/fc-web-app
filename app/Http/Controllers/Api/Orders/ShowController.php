<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

/**
 * Контроллер для просмотра детальной информации о заказе.
 * 
 * Что делает:
 * - Загружает заказ со всеми билетами и связанными данными
 * - Подсчитывает оставшееся время резерва
 * - Возвращает полную информацию для фронтенда
 */
class ShowController extends Controller
{
    /**
     * Возвращает детальную информацию о заказе.
     * 
     * @param int $id ID заказа
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        // Загружаем заказ со всеми связями
        // with() - это "жадная загрузка" (eager loading) - загружает всё за один запрос
        $order = Order::with([
            'tickets.seat.sector', // Билеты → Места → Секторы
            'tickets.game',        // Билеты → Матчи
            'user',                // Пользователь (если есть)
        ])->findOrFail($id);
        
        // Подсчитываем оставшееся время резерва в секундах
        $secondsUntilExpiry = $order->expires_at 
            ? max(0, now()->diffInSeconds($order->expires_at, false))
            : 0;
        
        // Получаем матч из первого билета (все билеты относятся к одному матчу)
        $game = $order->tickets->first()?->game;
        
        // Формируем ответ
        return response()->json([
            'data' => [
                'id' => $order->id,
                'status' => $order->status,
                'status_label' => $this->getStatusLabel($order->status), // Человекочитаемый статус
                'total_amount' => (float) $order->total_amount,
                'currency' => $order->currency,
                'created_at' => $order->created_at->toIso8601String(),
                'expires_at' => $order->expires_at?->toIso8601String(),
                'reservation_seconds_left' => $secondsUntilExpiry,
                'paid_at' => $order->paid_at?->toIso8601String(),
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
                        'qr_code_path' => $ticket->status === 'paid' ? $ticket->qr_code_path : null, // QR только для оплаченных
                    ];
                }),
                'game' => $game ? [
                    'id' => $game->id,
                    'title' => $game->title,
                    'home_team_name' => $game->home_team_name,
                    'away_team_name' => $game->away_team_name,
                    'start_at' => $game->start_at->toIso8601String(),
                    'status' => $game->status,
                ] : null,
            ],
        ]);
    }
    
    /**
     * Возвращает человекочитаемый статус заказа.
     * 
     * @param string $status Статус из БД
     * @return string
     */
    private function getStatusLabel(string $status): string
    {
        return match ($status) {
            'cart' => 'Корзина',
            'pending' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'cancelled' => 'Отменён',
            'expired' => 'Истёк',
            default => $status,
        };
    }
}


