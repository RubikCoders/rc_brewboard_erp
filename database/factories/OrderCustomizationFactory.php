<?php

namespace Database\Factories;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderCustomization>
 */
class OrderCustomizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderProduct = OrderProduct::find($this->faker->numberBetween(1001, 2000));
        $customizations = $orderProduct->product->customizations;
        $customizationOptions = $customizations->random();
        $customizationOption = $customizationOptions->options->random();

        return [
            "order_product_id" => $orderProduct->id,
            "product_customization_id" => $customizationOption->id,
        ];

    }
}
