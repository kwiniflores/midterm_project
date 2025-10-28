<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer; // import your model

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::firstOrCreate(
            ['email' => 'john@example.com'], // check by email
            [
                'name' => 'John Doe',
                'phone' => '+1 (555) 123-4567',
                'address' => '123 Main St, New York, NY 10001',
            ]
        );
    }
}
