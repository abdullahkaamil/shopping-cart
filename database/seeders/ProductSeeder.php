<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'price' => 59.99, 'stock_quantity' => 25],
            ['name' => 'Smart Fitness Tracker', 'price' => 39.99, 'stock_quantity' => 40],
            ['name' => 'Portable Power Bank 10000mAh', 'price' => 29.99, 'stock_quantity' => 60],
            ['name' => 'Mechanical Gaming Keyboard', 'price' => 89.99, 'stock_quantity' => 15],
            ['name' => 'Ultra-Thin Laptop Stand', 'price' => 24.99, 'stock_quantity' => 50],
            ['name' => 'Noise-Canceling Earbuds', 'price' => 79.99, 'stock_quantity' => 8],
            ['name' => 'LED Desk Lamp with USB', 'price' => 19.99, 'stock_quantity' => 100],
            ['name' => 'Wireless Mouse', 'price' => 15.99, 'stock_quantity' => 70],
            ['name' => '4K Webcam', 'price' => 49.99, 'stock_quantity' => 12],
            ['name' => 'Phone Tripod Mount', 'price' => 12.99, 'stock_quantity' => 90],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
