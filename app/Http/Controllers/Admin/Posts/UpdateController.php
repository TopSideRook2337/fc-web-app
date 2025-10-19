<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\UpdateRequest;
use App\Models\Post;
use App\Services\Admin\PostService;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, Post $post, PostService $postService)
    {
        $postService->update($post, $request->validated());
        
        return redirect()
            ->route('admin.posts.show', $post)
            ->with('success', 'Новость успешно обновлена!');
    }
}

