<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User;

class EditController extends Controller
{
    public function __invoke(User $user)
    {
        $roles = ['admin' => 'Администратор', 'manager' => 'Менеджер', 'user' => 'Пользователь'];
        
        return view('admin.users.edit', compact('user', 'roles'));
    }
}







