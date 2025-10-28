<?php

namespace App\Services\Admin;

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
                $order->update(['paid_at' => now()]);
                $order->tickets()->update(['status' => 'paid']);
                
                // Генерируем QR-коды для всех билетов
                $this->generateQrCodesForTickets($order);
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
}

