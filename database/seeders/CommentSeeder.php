<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are posts to comment on
        $posts = Post::query()->get();
        if ($posts->isEmpty()) {
            return; // Respect seeding order; PostSeeder should run first.
        }

        // Ensure there is at least one user
        $userIds = User::query()->pluck('id');
        if ($userIds->isEmpty()) {
            $userIds = collect([User::factory()->create()->id]);
        }

        // Ensure each post has exactly 3 comments
        foreach ($posts as $post) {
            $existing = $post->comments()->count();
            $toCreate = max(0, 3 - $existing);

            for ($i = 0; $i < $toCreate; $i++) {

                $date = fake()->dateTimeThisMonth();

                Comment::factory()
                    ->for($post)
                    ->state([
                        'user_id' => $userIds->random(),
                        'created_at' => $date,
                        'updated_at' => $date,
                        'published_at' => $date,
                    ])
                    ->create();
            }
        }
    }
}
