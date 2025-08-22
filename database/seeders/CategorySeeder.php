<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namesAndDescriptions = [
            'Artificial Intelligence' => 'Insights, tools, and trends about AI, from LLMs to computer vision and beyond.',
            'Cloud Computing' => 'Everything about cloud platforms, serverless, containers, and scalable architectures.',
            'Cybersecurity' => 'Best practices, vulnerabilities, and strategies to secure applications and infrastructure.',
            'Web Development' => 'Frontend and backend web technologies, frameworks, and performance optimization.',
            'Mobile Development' => 'iOS and Android development, cross-platform frameworks, and mobile UX patterns.',
            'DevOps' => 'CI/CD pipelines, infrastructure as code, observability, and platform engineering topics.',
            'Data Science' => 'Data analysis, visualization, and statistical methods for extracting insights from data.',
            'Machine Learning' => 'Algorithms, model training, feature engineering, and MLOps production workflows.',
            'Blockchain' => 'Distributed ledgers, smart contracts, and decentralized application development.',
            'Internet of Things' => 'Embedded systems, edge computing, and connecting devices to the cloud securely.',
        ];

        $images = ['100.jpg', '101.jpg', '102.jpg', '103.jpg', '104.jpg'];

        foreach ($namesAndDescriptions as $name => $content) {
            $image = $images[array_rand($images)];
            $date = fake()->dateTimeThisMonth;
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'content' => $content,
                'image' => $image, // stored on the `public` disk
                'published' => true,
                'published_at' => $date,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
