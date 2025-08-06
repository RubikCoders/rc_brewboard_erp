<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            // Granos de café
            [
                'name' => 'Café Espresso',
                'unit' => 'shots',
                'category' => 'granos',
                'description' => 'Granos de café espresso premium para bebidas base',
                'stock' => 150,
                'min_stock' => 30,
                'max_stock' => 200,
            ],
            [
                'name' => 'Café Descafeinado',
                'unit' => 'shots',
                'category' => 'granos',
                'description' => 'Granos de café descafeinado para clientes especiales',
                'stock' => 45,
                'min_stock' => 15,
                'max_stock' => 80,
            ],
            [
                'name' => 'Café Orgánico',
                'unit' => 'shots',
                'category' => 'granos',
                'description' => 'Granos de café orgánico certificado',
                'stock' => 60,
                'min_stock' => 20,
                'max_stock' => 100,
            ],

            // Lácteos
            [
                'name' => 'Leche Entera',
                'unit' => 'ml',
                'category' => 'lácteos',
                'description' => 'Leche entera fresca para bebidas cremosas',
                'stock' => 5000,
                'min_stock' => 1000,
                'max_stock' => 8000,
            ],
            [
                'name' => 'Leche Deslactosada',
                'unit' => 'ml',
                'category' => 'lácteos',
                'description' => 'Leche sin lactosa para clientes intolerantes',
                'stock' => 2500,
                'min_stock' => 500,
                'max_stock' => 4000,
            ],
            [
                'name' => 'Leche de Soya',
                'unit' => 'ml',
                'category' => 'lácteos',
                'description' => 'Bebida vegetal de soya como alternativa láctea',
                'stock' => 1800,
                'min_stock' => 300,
                'max_stock' => 3000,
            ],
            [
                'name' => 'Leche de Almendra',
                'unit' => 'ml',
                'category' => 'lácteos',
                'description' => 'Bebida vegetal de almendra premium',
                'stock' => 1200,
                'min_stock' => 200,
                'max_stock' => 2000,
            ],
            [
                'name' => 'Crema Batida',
                'unit' => 'g',
                'category' => 'lácteos',
                'description' => 'Crema batida fresca para decorar bebidas',
                'stock' => 800,
                'min_stock' => 150,
                'max_stock' => 1200,
            ],

            // Jarabes y endulzantes
            [
                'name' => 'Jarabe de Vainilla',
                'unit' => 'ml',
                'category' => 'jarabes',
                'description' => 'Jarabe sabor vainilla natural',
                'stock' => 750,
                'min_stock' => 100,
                'max_stock' => 1000,
            ],
            [
                'name' => 'Jarabe de Caramelo',
                'unit' => 'ml',
                'category' => 'jarabes',
                'description' => 'Jarabe de caramelo dulce para bebidas especiales',
                'stock' => 650,
                'min_stock' => 100,
                'max_stock' => 1000,
            ],
            [
                'name' => 'Jarabe de Chocolate',
                'unit' => 'ml',
                'category' => 'jarabes',
                'description' => 'Jarabe de chocolate belga premium',
                'stock' => 500,
                'min_stock' => 80,
                'max_stock' => 800,
            ],
            [
                'name' => 'Jarabe de Almendra',
                'unit' => 'ml',
                'category' => 'jarabes',
                'description' => 'Jarabe con sabor a almendra',
                'stock' => 400,
                'min_stock' => 60,
                'max_stock' => 600,
            ],
            [
                'name' => 'Jarabe de Crema Irlandesa',
                'unit' => 'ml',
                'category' => 'jarabes',
                'description' => 'Jarabe sabor crema irlandesa',
                'stock' => 350,
                'min_stock' => 50,
                'max_stock' => 500,
            ],
            [
                'name' => 'Azúcar Blanca',
                'unit' => 'g',
                'category' => 'endulzantes',
                'description' => 'Azúcar refinada estándar',
                'stock' => 3000,
                'min_stock' => 500,
                'max_stock' => 5000,
            ],
            [
                'name' => 'Stevia Natural',
                'unit' => 'sobres',
                'category' => 'endulzantes',
                'description' => 'Edulcorante natural de stevia en sobres',
                'stock' => 200,
                'min_stock' => 50,
                'max_stock' => 400,
            ],
            [
                'name' => 'Splenda',
                'unit' => 'sobres',
                'category' => 'endulzantes',
                'description' => 'Edulcorante artificial en sobres',
                'stock' => 180,
                'min_stock' => 40,
                'max_stock' => 300,
            ],

            // Otros ingredientes
            [
                'name' => 'Chocolate en Polvo',
                'unit' => 'g',
                'category' => 'otros',
                'description' => 'Cacao en polvo para bebidas de chocolate',
                'stock' => 1500,
                'min_stock' => 200,
                'max_stock' => 2500,
            ],
            [
                'name' => 'Matcha en Polvo',
                'unit' => 'g',
                'category' => 'otros',
                'description' => 'Té verde matcha japonés en polvo',
                'stock' => 300,
                'min_stock' => 50,
                'max_stock' => 500,
            ],
            [
                'name' => 'Concentrado de Chai',
                'unit' => 'ml',
                'category' => 'otros',
                'description' => 'Concentrado de especias chai para té especiado',
                'stock' => 800,
                'min_stock' => 100,
                'max_stock' => 1200,
            ],
            [
                'name' => 'Agua Caliente',
                'unit' => 'ml',
                'category' => 'otros',
                'description' => 'Agua filtrada y calentada para infusiones',
                'stock' => 10000,
                'min_stock' => 2000,
                'max_stock' => 15000,
            ],
            [
                'name' => 'Hielo',
                'unit' => 'cubos',
                'category' => 'otros',
                'description' => 'Hielo para bebidas frías',
                'stock' => 500,
                'min_stock' => 100,
                'max_stock' => 800,
            ],

            // Tés
            [
                'name' => 'Té Negro',
                'unit' => 'sobres',
                'category' => 'tés',
                'description' => 'Té negro premium en bolsitas',
                'stock' => 120,
                'min_stock' => 30,
                'max_stock' => 200,
            ],
            [
                'name' => 'Té Verde',
                'unit' => 'sobres',
                'category' => 'tés',
                'description' => 'Té verde natural en bolsitas',
                'stock' => 100,
                'min_stock' => 25,
                'max_stock' => 180,
            ],
            [
                'name' => 'Té Rojo (Rooibos)',
                'unit' => 'sobres',
                'category' => 'tés',
                'description' => 'Té rooibos sin cafeína',
                'stock' => 80,
                'min_stock' => 20,
                'max_stock' => 150,
            ],
            [
                'name' => 'Manzanilla',
                'unit' => 'sobres',
                'category' => 'tés',
                'description' => 'Infusión de manzanilla relajante',
                'stock' => 90,
                'min_stock' => 20,
                'max_stock' => 160,
            ],

            // Suministros operativos
            [
                'name' => 'Vasos Pequeños',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Vasos desechables de 8oz',
                'stock' => 250,
                'min_stock' => 50,
                'max_stock' => 500,
            ],
            [
                'name' => 'Vasos Medianos',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Vasos desechables de 12oz',
                'stock' => 300,
                'min_stock' => 60,
                'max_stock' => 600,
            ],
            [
                'name' => 'Vasos Grandes',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Vasos desechables de 16oz',
                'stock' => 200,
                'min_stock' => 40,
                'max_stock' => 400,
            ],
            [
                'name' => 'Tapas para Vasos',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Tapas plásticas para vasos desechables',
                'stock' => 400,
                'min_stock' => 80,
                'max_stock' => 800,
            ],
            [
                'name' => 'Servilletas',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Servilletas de papel blancas',
                'stock' => 1000,
                'min_stock' => 200,
                'max_stock' => 2000,
            ],
            [
                'name' => 'Removedores',
                'unit' => 'unidades',
                'category' => 'suministros',
                'description' => 'Palitos de madera para revolver',
                'stock' => 800,
                'min_stock' => 150,
                'max_stock' => 1500,
            ],
        ];

        foreach ($ingredients as $ingredientData) {
            // Separar datos del inventario
            $stockData = [
                'stock' => $ingredientData['stock'],
                'min_stock' => $ingredientData['min_stock'],
                'max_stock' => $ingredientData['max_stock'],
            ];

            unset($ingredientData['stock'], $ingredientData['min_stock'], $ingredientData['max_stock']);

            // Crear ingrediente
            $ingredient = Ingredient::create($ingredientData);

            // Crear inventario asociado
            Inventory::create([
                'stockable_type' => Ingredient::class,
                'stockable_id' => $ingredient->id,
                'stock' => $stockData['stock'],
                'min_stock' => $stockData['min_stock'],
                'max_stock' => $stockData['max_stock'],
            ]);
        }
    }
}