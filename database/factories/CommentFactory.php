<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $date = fake()->dateTimeThisMonth();

        return [
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(3, true),
            'published' => fake()->boolean(),
            'post_id' => rand(1, Post::count()),
            'user_id' => rand(1, User::count()),
            'published_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
