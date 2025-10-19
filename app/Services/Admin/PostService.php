<?php

namespace App\Services\Admin;

use App\Models\Post;
use Illuminate\Support\Str;

class PostService
{
    public function store(array $data): Post
    {
        // Генерируем slug из заголовка
        $data['slug'] = Str::slug($data['title']);
        
        // Устанавливаем автора
        $data['author_id'] = auth()->id();
        
        // Если статус published, устанавливаем дату публикации
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }
        
        return Post::create($data);
    }
    
    public function update(Post $post, array $data): Post
    {
        // Обновляем slug если изменился заголовок
        if ($data['title'] !== $post->title) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        // Если статус изменился на published, устанавливаем дату публикации
        if ($data['status'] === 'published' && $post->status !== 'published') {
            $data['published_at'] = now();
        }
        
        $post->update($data);
        
        return $post;
    }
}

