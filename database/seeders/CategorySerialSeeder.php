<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategorySerial;

class CategorySerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 13; $i++) {
            CategorySerial::create([
                'section' => 'home',
                'category_id' => $i,
                'serial' => $i
            ]);
        }

        echo "Category Serial Seeding Complete!";
    }
}
