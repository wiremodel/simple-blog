<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()
            ->count(50)
            ->afterCreating(function (Post $post) {

                $post
                    ->categories()
                    ->attach(rand(1, Category::count()));

                $comments = Comment::factory()
                    ->count(10)
                    ->create([
                        'post_id' => $post->id,
                        'user_id' => rand(1, User::count()),
                    ]);
            })
            ->create([
                'user_id' => rand(1, User::count()),
            ]);
    }
}
