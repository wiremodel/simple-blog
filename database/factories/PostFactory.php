<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $title = fake()->sentence(4);
        $slug = str($title)->slug();
        $date = fake()->dateTimeThisMonth();
        return [
            'title' => $title,
            'slug' => $slug,
            'content' => fake()->paragraphs(3, true),
            'image' => fake()->randomElement(['100.jpg', '104.jpg', '106.jpg', '110.jpg', '120.jpg']),
            'tags' => fake()->randomElements(['tailwindcss', 'alpinejs', 'laravel', 'livewire', 'php'], 2),
            'published' => true,
            'user_id' => rand(1, User::count()),
            'published_at' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
