<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\UpdateRequest;
use App\Models\Order;
use App\Services\Admin\OrderService;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Order $order, OrderService $service)
    {
        $data = $request->validated();
        
        $service->updateStatus($order, $data['status']);
        
        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Статус заказа успешно обновлен.');
    }
}

