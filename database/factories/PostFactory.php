<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'excerpt' => fake()->word(),
            'content' => fake()->paragraphs(3, true),
            'image' => fake()->word(),
            'tags' => '{}',
            'published' => fake()->boolean(),
            'published_at' => fake()->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
