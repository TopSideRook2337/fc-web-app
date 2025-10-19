<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\StoreRequest;
use App\Services\Admin\PostService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, PostService $postService)
    {
        $post = $postService->store($request->validated());
        
        return redirect()
            ->route('admin.posts.show', $post)
            ->with('success', 'Новость успешно создана!');
    }
}

