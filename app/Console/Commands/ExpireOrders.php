<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отменяет истекшие заказы (корзины и неоплаченные заказы через 15 минут)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🕐 Проверка истекших заказов...');
        
        // Находим все заказы с истекшим сроком
        $expiredOrders = Order::query()
            ->whereIn('status', ['cart', 'pending'])
            ->where('expires_at', '<', now())
            ->whereNotNull('expires_at')
            ->with('tickets')
            ->get();
        
        if ($expiredOrders->isEmpty()) {
            $this->info('✅ Истекших заказов не найдено');
            return Command::SUCCESS;
        }
        
        $expiredCount = 0;
        $ticketsCount = 0;
        
        // Обрабатываем каждый истекший заказ
        foreach ($expiredOrders as $order) {
            $ticketsInOrder = $order->tickets->count();
            
            // Обновляем статус заказа
            $order->update(['status' => 'expired']);
            
            // Отменяем все билеты (освобождаем места)
            $order->tickets()->update(['status' => 'cancelled']);
            
            $expiredCount++;
            $ticketsCount += $ticketsInOrder;
            
            // Логируем
            Log::info("Заказ #{$order->id} истёк. Освобождено билетов: {$ticketsInOrder}", [
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'tickets_count' => $ticketsInOrder,
                'expires_at' => $order->expires_at,
            ]);
            
            $this->line("  ❌ Заказ #{$order->id} → истёк (билетов: {$ticketsInOrder})");
        }
        
        // Итоговый отчёт
        $this->newLine();
        $this->info("✅ Обработано:");
        $this->info("   • Заказов истекло: {$expiredCount}");
        $this->info("   • Билетов освобождено: {$ticketsCount}");
        
        Log::info("Команда orders:expire завершена", [
            'expired_orders' => $expiredCount,
            'freed_tickets' => $ticketsCount,
        ]);
        
        return Command::SUCCESS;
    }
}

