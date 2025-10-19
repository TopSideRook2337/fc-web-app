<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request, Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }
}

