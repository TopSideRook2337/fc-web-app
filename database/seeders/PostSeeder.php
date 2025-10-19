<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создаем только 3 тестовые записи, остальные создаст FootballNewsSeeder
        $posts = [
            [
                'title' => 'Тестовая новость 1',
                'slug' => 'test-news-1',
                'author_name' => 'Тестер',
                'excerpt' => 'Это тестовая новость для проверки функциональности.',
                'content' => 'Полное содержание тестовой новости для проверки работы системы.',
                'status' => 'published',
                'published_at' => now(),
                'author_id' => 1,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
