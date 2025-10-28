<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;

class EditController extends Controller
{
    public function __invoke(Order $order)
    {
        $statuses = [
            'cart' => 'Корзина',
            'pending' => 'Ожидает оплаты',
            'paid' => 'Оплачен',
            'cancelled' => 'Отменен',
            'expired' => 'Истек',
        ];
        
        return view('admin.orders.edit', compact('order', 'statuses'));
    }
}

