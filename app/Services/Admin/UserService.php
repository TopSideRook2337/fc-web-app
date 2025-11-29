<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Создание нового пользователя
     */
    public function store(array $data): User
    {
        // Хешируем пароль
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        // Устанавливаем роль по умолчанию, если не указана
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }
        
        return User::create($data);
    }
    
    /**
     * Обновление существующего пользователя
     */
    public function update(User $user, array $data): User
    {
        // Хешируем пароль только если он был передан
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Если пароль не передан или пустой, удаляем его из данных
            unset($data['password']);
        }
        
        $user->update($data);
        
        return $user->fresh();
    }
}







