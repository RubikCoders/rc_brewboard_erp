<?php

namespace Database\Seeders;

use App\Models\MenuProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bebidas calientes > con café
        MenuProduct::create([
            'id' => 1001,
            'category_id' => 1001,
            'name' => 'Latte',
            'description' => 'Café con leche al vapor.',
            'ingredients' => 'Café espresso, leche a elección',
            'base_price' => 45,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1002,
            'category_id' => 1001,
            'name' => 'Latte Caramelo',
            'description' => 'Latte con jarabe de caramelo.',
            'ingredients' => 'Café espresso, leche, caramelo',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1003,
            'category_id' => 1001,
            'name' => 'Capuccino',
            'description' => 'Café con espuma de leche.',
            'ingredients' => 'Café espresso, leche espumada',
            'base_price' => 45,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1004,
            'category_id' => 1001,
            'name' => 'Mocha / Mocha Blanco',
            'description' => 'Café con leche y chocolate.',
            'ingredients' => 'Café espresso, leche, chocolate',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1005,
            'category_id' => 1001,
            'name' => 'Americano',
            'description' => 'Café solo, estilo americano.',
            'ingredients' => 'Café espresso, agua caliente',
            'base_price' => 35,
            'estimated_time_min' => 4,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1006,
            'category_id' => 1001,
            'name' => 'Espresso',
            'description' => 'Café espresso concentrado.',
            'ingredients' => 'Café espresso',
            'base_price' => 30,
            'estimated_time_min' => 3,
            'is_available' => true,
        ]);

// Bebidas calientes > sin café
        MenuProduct::create([
            'id' => 1007,
            'category_id' => 1001,
            'name' => 'Chocolate',
            'description' => 'Bebida caliente de chocolate.',
            'ingredients' => 'Leche, chocolate, toppings',
            'base_price' => 45,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1008,
            'category_id' => 1001,
            'name' => 'Matcha',
            'description' => 'Bebida caliente de té verde matcha.',
            'ingredients' => 'Leche, matcha',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1009,
            'category_id' => 1001,
            'name' => 'Chai',
            'description' => 'Infusión especiada con leche.',
            'ingredients' => 'Concentrado de chai, leche',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1010,
            'category_id' => 1001,
            'name' => 'Té',
            'description' => 'Variedad de tés calientes.',
            'ingredients' => 'Té a elección, agua caliente',
            'base_price' => 40,
            'estimated_time_min' => 4,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1011,
            'category_id' => 1001,
            'name' => 'Tisanas',
            'description' => 'Infusión de frutas naturales.',
            'ingredients' => 'Frutas secas, agua caliente',
            'base_price' => 45,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        // Bebidas frías > con café
        MenuProduct::create([
            'id' => 1012,
            'category_id' => 1002,
            'name' => 'Latte frío',
            'description' => 'Versión fría del clásico latte.',
            'ingredients' => 'Café, hielo, leche',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1013,
            'category_id' => 1002,
            'name' => 'Capuccino frío',
            'description' => 'Capuccino servido con hielo.',
            'ingredients' => 'Café, leche, hielo',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1014,
            'category_id' => 1002,
            'name' => 'Cold Brew',
            'description' => 'Café infusionado en frío.',
            'ingredients' => 'Cold brew, hielo',
            'base_price' => 55,
            'estimated_time_min' => 6,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1015,
            'category_id' => 1002,
            'name' => 'Americano frío',
            'description' => 'Americano servido con hielo.',
            'ingredients' => 'Café americano, hielo',
            'base_price' => 40,
            'estimated_time_min' => 4,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1016,
            'category_id' => 1002,
            'name' => 'Frappe Café',
            'description' => 'Frappe a base de café con sabores.',
            'ingredients' => 'Café, hielo, leche, saborizante',
            'base_price' => 60,
            'estimated_time_min' => 6,
            'is_available' => true,
        ]);

// Bebidas frías > sin café
        MenuProduct::create([
            'id' => 1017,
            'category_id' => 1002,
            'name' => 'Chocolate frío',
            'description' => 'Chocolate frío o frappe.',
            'ingredients' => 'Leche, chocolate, hielo',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1018,
            'category_id' => 1002,
            'name' => 'Matcha frío',
            'description' => 'Té verde matcha frío o frappe.',
            'ingredients' => 'Leche, matcha, hielo',
            'base_price' => 55,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1019,
            'category_id' => 1002,
            'name' => 'Chai frío',
            'description' => 'Chai frío especiado.',
            'ingredients' => 'Chai, leche, hielo',
            'base_price' => 55,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1020,
            'category_id' => 1002,
            'name' => 'Tisanas frías',
            'description' => 'Infusión de frutas servida fría.',
            'ingredients' => 'Frutas secas, agua fría',
            'base_price' => 50,
            'estimated_time_min' => 5,
            'is_available' => true,
        ]);

// Alimentos
        MenuProduct::create([
            'id' => 1021,
            'category_id' => 1003,
            'name' => 'Paninis',
            'description' => 'Paninis calientes con variedad de ingredientes.',
            'ingredients' => 'Pan, relleno a elección',
            'base_price' => 65,
            'estimated_time_min' => 8,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1022,
            'category_id' => 1003,
            'name' => 'Rebanada de pastel',
            'description' => 'Rebanada de pastel artesanal.',
            'ingredients' => 'Harina, azúcar, sabor a elección',
            'base_price' => 40,
            'estimated_time_min' => 2,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1023,
            'category_id' => 1003,
            'name' => 'Galletas artesanales',
            'description' => 'Galletas horneadas artesanalmente.',
            'ingredients' => 'Harina, azúcar, mantequilla',
            'base_price' => 20,
            'estimated_time_min' => 2,
            'is_available' => true,
        ]);

        MenuProduct::create([
            'id' => 1024,
            'category_id' => 1003,
            'name' => 'Brownie',
            'description' => 'Brownie de chocolate con toppings.',
            'ingredients' => 'Chocolate, harina, huevo, toppings',
            'base_price' => 35,
            'estimated_time_min' => 4,
            'is_available' => true,
        ]);

    }
}
