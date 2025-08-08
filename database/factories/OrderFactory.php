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
        $status = $this->faker->randomElement([1, 1, 1, 1, 1, 1, 0, 0, 0, 2]);
        $paymentMethod = $this->faker->randomElement(['efectivo', 'tarjeta']);
        $paymentFolio = $paymentMethod == "tarjeta" ? $this->faker->numerify('######') : null;

        $data = [
            'employee_id' => $this->faker->randomElement([1002, 1003, 1004]),
            'customer_name' => $this->faker->name(),
            'total' => $this->faker->randomFloat(2, 50, 1000),
            'tax' => $this->faker->randomFloat(2, 5, 100),
            'payment_method' => $paymentMethod,
            'payment_folio' => $paymentFolio,
            'from' => $this->faker->randomElement(['erp', 'csp']),
            'status' => $status,
            'created_at' => $this->faker->dateTimeBetween('-12 months', 'now'),
        ];

        if ($status === 2) {
            $data['cancel_reason'] = $this->faker->sentence();
        }

        return $data;
    }
}
