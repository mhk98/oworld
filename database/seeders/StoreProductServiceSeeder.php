<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoreProduct;
use App\Models\StoreService;

class StoreProductServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Products
        $products = [
            'iPhone 13',
            'Samsung Galaxy S21',
            'HP Pavilion Laptop',
            'Apple MacBook Pro',
            'Sony PlayStation 5',
        ];

        // Insert products
        foreach ($products as $productName) {
            StoreProduct::create([
                'store_id' => 14,
                'product' => $productName
            ]);
        }

        // Services
        $services = [
            'Mobile Phone Repair',
            'Laptop Repair',
            'Screen Replacement',
            'Data Recovery',
            'Software Installation',
        ];

        // Insert services
        foreach ($services as $serviceName) {
            StoreService::create([
                'store_id' => 14,
                'service' => $serviceName
            ]);
        }


        echo "Products and Services Data Insert Complete";
    }
}