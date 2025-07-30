<?php

namespace Database\Seeders;

use App\Models\MenuProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuProductSeeder extends Seeder
{
    private const DS = DIRECTORY_SEPARATOR;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bebidas calientes > con café
        MenuProduct::create([
            'id' => 1001,
            'category_id' => 1001,
            'image_url' => 'storage/products/latte.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'latte.png'),
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
            'image_url' => 'storage/products/caramel_latte.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'caramel_latte.png'),
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
            'image_url' => 'storage/products/capuccino.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'capuccino.png'),
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
            'image_url' => 'storage/products/mocha.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'mocha.png'),
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
            'image_url' => 'storage/products/american.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'american.png'),
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
            'image_url' => 'storage/products/espresso.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'espresso.png'),
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
            'image_url' => 'storage/products/chocolate.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'chocolate.png'),
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
            'image_url' => 'storage/products/matcha.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'matcha.png'),
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
            'image_url' => 'storage/products/chai.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'chai.png'),
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
            'image_url' => 'storage/products/tea.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'tea.png'),
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
            'image_url' => 'storage/products/herbal_tea.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'herbal_tea.png'),
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
            'image_url' => 'storage/products/cold_latte.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_latte.png'),
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
            'image_url' => 'storage/products/cold_capuccino.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_capuccino.png'),
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
            'image_url' => 'storage/products/cold_brew.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_brew.png'),
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
            'image_url' => 'storage/products/cold_american.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_american.png'),
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
            'image_url' => 'storage/products/frappe.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'frappe.png'),
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
            'image_url' => 'storage/products/cold_chocolate.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_chocolate.png'),
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
            'image_url' => 'storage/products/cold_matcha.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_matcha.png'),
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
            'image_url' => 'storage/products/cold_chai.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_chai.png'),
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
            'image_url' => 'storage/products/cold_herbal_tea.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cold_herbal_tea.png'),
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
            'image_url' => 'storage/products/panini.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'panini.png'),
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
            'image_url' => 'storage/products/cake.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cake.png'),
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
            'image_url' => 'storage/products/cookies.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'cookies.png'),
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
            'image_url' => 'storage/products/brownie.png',
            'image_path' => storage_path('app' . self::DS . 'public' . self::DS . 'products' . self::DS . 'brownie.png'),
            'name' => 'Brownie',
            'description' => 'Brownie de chocolate con toppings.',
            'ingredients' => 'Chocolate, harina, huevo, toppings',
            'base_price' => 35,
            'estimated_time_min' => 4,
            'is_available' => true,
        ]);

    }
}
