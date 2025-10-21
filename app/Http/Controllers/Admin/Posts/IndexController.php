<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Http\Filters\Admin\Posts\PostFilter;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;
        
        // Если нет сортировки, используем сортировку по умолчанию
        if (!$request->has('sort_by')) {
            $request->merge(['sort_by' => 'created_at', 'sort_direction' => 'desc']);
        }
        
        $posts = Post::filter(new PostFilter($request))
            ->paginate($perPage)
            ->appends($request->query());

        return view('admin.posts.index', compact('posts'));
    }
}

