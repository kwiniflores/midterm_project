<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class SaleFactory extends Factory
{
    public function definition()
    {
        return [
            ‘customer_id’ => Customer::factory(),
            ‘invoice_number’ => ‘INV-‘ . str_pad($this->faker->unique()->numberBetween(1, 999999), 6, ‘0’, STR_PAD_LEFT),
            ‘total_amount’ => $this->faker->randomFloat(2, 50, 2000),
            ‘tax_amount’ => $this->faker->randomFloat(2, 5, 100),
            ‘discount_amount’ => $this->faker->randomFloat(2, 0, 50),
            ‘status’ => $this->faker->randomElement([‘pending’, ‘completed’, ‘cancelled’]),
            ‘sale_date’ => $this->faker->dateTimeBetween(‘-30 days’, ‘now’),
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                ‘status’ => ‘pending’,
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            Return [
                ‘status’ => ‘completed’,
            ];
        });
    }

    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                ‘status’ => ‘cancelled’,
            ];
        });
    }
}