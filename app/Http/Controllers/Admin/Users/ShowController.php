<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class ShowController extends Controller
{
    public function __invoke(User $user)
    {
        $user->load(['orders']);
        
        // Подсчитываем количество заказов и билетов
        $ordersCount = $user->orders()->count();
        $ticketsCount = \App\Models\Ticket::whereHas('order', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        return view('admin.users.show', compact('user', 'ordersCount', 'ticketsCount'));
    }
}







