<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Filters\Admin\Users\UserFilter;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;
        
        // Если нет сортировки, используем сортировку по умолчанию
        if (!$request->has('sort_by')) {
            $request->merge(['sort_by' => 'created_at', 'sort_direction' => 'desc']);
        }
        
        $query = User::query();
        
        // Разграничение ролей: не-admin видит только связанных пользователей
        if (auth()->user()->role !== 'admin') {
            // Получаем ID пользователей, с которыми работал текущий менеджер
            // через заказы (orders.user_id)
            $relatedUserIds = \App\Models\Order::whereHas('tickets', function ($q) {
                // Можно добавить дополнительную логику, если нужно
            })->pluck('user_id')->unique();
            
            $query->whereIn('id', $relatedUserIds);
        }
        
        $users = $query->filter(new UserFilter($request))
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.users.index', compact('users'));
    }
}







