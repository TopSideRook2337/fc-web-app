<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __invoke()
    {
        $roles = ['admin' => 'Администратор', 'manager' => 'Менеджер', 'user' => 'Пользователь'];
        
        return view('admin.users.create', compact('roles'));
    }
}







