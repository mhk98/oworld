<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str; 

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fashion',
            'Beauty',
            'Home and Living',
            'Travel',
            'Events and Entertainment',
            'Tech and Electronics',
            'Health and Wellness',
            'Groceries',
            'Education and Work',
            'Business Services',
            'Automotive',
            'Social Services',
            'Food',
        ];

         foreach ($categories as $category) {
            Category::create([
                'title' => $category,
                'slug' => Str::slug($category, '-'),
            ]);
        }

        echo "Categories Insert";
    }
}
