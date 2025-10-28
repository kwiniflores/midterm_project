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
        Product::firstOrCreate(
            ['sku' => 'LAP-001'], // unique column to check
            [
                'name' => 'Laptop Computer',
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'price' => 999.99,
                'stock_quantity' => 25,
            ]
        );
    }
}
