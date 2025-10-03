<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->select('id', 'title', 'slug', 'excerpt', 'published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return response()->json($posts);
    }
}
