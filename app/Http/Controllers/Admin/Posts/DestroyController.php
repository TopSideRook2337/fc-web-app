<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        $post->delete();
        
        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Новость успешно удалена!');
    }
}

