<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use App\Services\Admin\UserService;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user, UserService $userService)
    {
        $user = $userService->update($user, $request->validated());
        
        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Пользователь успешно обновлён!');
    }
}







