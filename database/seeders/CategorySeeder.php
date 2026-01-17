<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tanaman Hias Daun',
                'slug' => 'tanaman_hias_daun',
                'description' => 'Berbagai tanaman hias daun yang indah dan mudah dirawat',
                'image' => 'categories/tanaman_hias_daun.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Tanaman Hias Bunga',
                'slug' => 'tanaman_hias_bunga',
                'description' => 'Berbagai tanaman hias bunga yang indah dan mudah dirawat',
                'image' => 'categories/tanaman_hias_bunga.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Tanaman Hias Batang',
                'slug' => 'tanaman_hias_batang',
                'description' => 'Berbagai tanaman hias batang yang indah dan mudah dirawat',
                'image' => 'categories/tanaman_hias_batang.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}