<?php

namespace Database\Factories;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProductCustomization>
 */
class OrderProductCustomizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderProduct = OrderProduct::find($this->faker->numberBetween(1001, 2000));
        Log::info("orderProduct: " . $orderProduct);
        $customizations = $orderProduct->product->customizations;
        Log::info("customizations: " . $customizations);
        $customizationOptions = $customizations->random();
        Log::info("customizationOptions: " . $customizationOptions);
        $customizationOption = $customizationOptions->options->random();
        Log::info("customizationOption: " . $customizationOption);

        return [
            "order_product_id" => $orderProduct->id,
            "product_customization_id" => $customizationOption->id,
        ];

    }
}
