<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;

class ShowController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->load(['user', 'tickets.game', 'tickets.seat.sector']);
        
        return view('admin.orders.show', compact('order'));
    }
}

