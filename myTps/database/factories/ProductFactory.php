Namespace Database\Factories;

Use Illuminate\Database\Eloquent\Factories\Factory;

Class ProductFactory extends Factory
{
    Public function definition()
    {
        Return [
            ‘name’ => $this->faker->words(2, true),
            ‘description’ => $this->faker->sentence(),
            ‘price’ => $this->faker->randomFloat(2, 10, 1000),
            ‘stock_quantity’ => $this->faker->numberBetween(0, 100),
            ‘sku’ => strtoupper($this->faker->bothify(‘???-###’)),
        ];
    }
}