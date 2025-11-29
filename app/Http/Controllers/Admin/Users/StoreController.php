<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Services\Admin\UserService;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, UserService $userService)
    {
        $user = $userService->store($request->validated());
        
        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Пользователь успешно создан!');
    }
}







