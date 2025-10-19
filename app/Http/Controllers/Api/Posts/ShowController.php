<?php

namespace App\Http\Controllers\Api\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class ShowController extends Controller
{
    public function __invoke(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->firstOrFail([
                'id',
                'title',
                'slug',
                'content',
                'excerpt',
                'published_at',
                'author_id'
            ]);

        return response()->json($post);
    }
}
