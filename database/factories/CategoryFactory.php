<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = fake()->sentence(4);
        $slug = str($name)->slug();

        return [
            'name' => $name,
            'slug' => $slug,
            'content' => fake()->paragraphs(3, true),
            'image' => fake()->randomElement(['100.jpg', '104.jpg', '106.jpg', '110.jpg', '120.jpg']),
            'published' => fake()->boolean(),
            'published_at' => fake()->dateTimeThisMonth(),
        ];
    }
}
