<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read the article content from the public disk
        $content = '';
        $path = 'article-content.html';

        if (Storage::disk('public')->exists($path)) {
            $content = Storage::disk('public')->get($path);
        } else {
            // Fallback content in case the file is missing
            $content = '<p>Sample article content</p>';
        }

        // Use the same images as CategorySeeder
        $images = ['100.jpg', '101.jpg', '102.jpg', '103.jpg', '104.jpg'];

        $categoriesCount = Category::query()->count();
        if ($categoriesCount === 0) {
            return; // Nothing to attach; respect seeding order in DatabaseSeeder
        }

        // Ensure there is at least one user to relate posts to
        $userIds = User::query()->pluck('id');
        if ($userIds->isEmpty()) {
            // Create a default user via factory if none exist
            $userIds = collect([User::factory()->create()->id]);
        }

        // Create 10 posts
        for ($i = 1; $i <= 10; $i++) {
            $title = fake()->unique()->sentence(6);
            $date = fake()->dateTimeThisMonth();

            $post = Post::create([
                'title' => $title,
                'slug' => Str::slug($title).'-'.$i,
                'content' => $content,
                'thumbnail' => $images[array_rand($images)],
                'featured_image' => $images[array_rand($images)],
                'gallery' => [
                    $images[array_rand($images)],
                    $images[array_rand($images)],
                    $images[array_rand($images)],
                ],
                'tags' => [fake()->word(), fake()->word(), fake()->word()],
                'status' => PostStatus::Published->value,
                'published_at' => $date,
                'user_id' => $userIds->random(),
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            // Attach at least 3 random categories
            $take = max(3, min(5, $categoriesCount));
            $categoryIds = Category::query()->inRandomOrder()->take($take)->pluck('id')->all();
            $post->categories()->sync($categoryIds);
        }
    }
}
