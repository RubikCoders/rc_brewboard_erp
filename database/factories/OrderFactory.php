<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed> 
     */
    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->randomElement([1002, 1003, 1004]),
            'customer_name' => $this->faker->name(),
            'total' => $this->faker->randomFloat(2, 50, 1000),
            'tax' => $this->faker->randomFloat(2, 5, 100),
            'payment_method' => $this->faker->randomElement(['efectivo', 'tarjeta']),
            'from' => $this->faker->randomElement(['erp', 'csp']),
            'status' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
