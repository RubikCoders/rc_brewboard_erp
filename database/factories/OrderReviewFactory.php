<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderReview>
 */
class OrderReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'El café estaba frío.',
            'Excelente atención del barista.',
            'Muy buena ambientación.',
            'Los precios son altos para la calidad ofrecida.',
            'Me encantó el pastel de zanahoria.',
            'Servicio lento, pero amable.',
            'No tenían opciones sin lactosa.',
            'El lugar estaba limpio y ordenado.',
            'Tardaron mucho en tomar mi orden.',
            'El espresso es de los mejores que he probado.',
            'La música estaba demasiado alta.',
            'Buena relación calidad-precio.',
            'El pan estaba duro.',
            'Gran variedad de postres.',
            'Muy recomendable para ir a trabajar o estudiar.',
            'La conexión Wi-Fi no funcionaba bien.',
            'El frappé estaba delicioso.',
            'El baño no estaba limpio.',
            'Me ofrecieron una muestra gratis.',
            'Volveré sin duda.',
        ];

        $images = [
            'example_1.png',
            'example_2.png',
            'example_3.png',
            'example_4.png',
            'example_5.png',
            'example_6.png',
            'example_7.png',
            'example_8.png',
            'example_9.png'
        ];

        return [
            'order_id' => $this->faker->numberBetween(1001, 1280),
            'rating' => $this->faker->biasedNumberBetween(0, 10, function ($x) {
                return pow($x, 3);
            }),
            'comment' => $this->faker->randomElement($comments),
            'image_path' => $this->faker->randomElement($images),
            'created_at' => $this->faker->dateTimeBetween('-12 months', 'now'),
        ];
    }
}
