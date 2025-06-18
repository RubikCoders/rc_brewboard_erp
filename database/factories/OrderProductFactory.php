<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "order_id" => $this->faker->numberBetween(1001, 1280),
            "product_id" => $this->faker->numberBetween(1001, 1024),
            "quantity" => $this->faker->numberBetween(1, 10),
            "is_delivered" => $this->faker->boolean(90),
            "total_price" => $this->faker->randomFloat(2, 50, 1000),
            "notes" => $this->faker->sentence(),
            "kitchen_status" => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
