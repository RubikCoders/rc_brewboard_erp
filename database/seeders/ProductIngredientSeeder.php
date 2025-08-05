<?php

namespace Database\Seeders;

use App\Models\MenuProduct;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener productos y ingredientes existentes
        $products = MenuProduct::all()->keyBy('name');
        $ingredients = Ingredient::all()->keyBy('name');

        // Definir las recetas (qué ingredientes necesita cada producto)
        $recipes = [
            'Latte' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Base de la bebida'],
                ['ingredient' => 'Leche Entera', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Calentar a 65°C'],
            ],
            'Cappuccino' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Espresso doble'],
                ['ingredient' => 'Leche Entera', 'quantity' => 150, 'unit' => 'ml', 'notes' => 'Espumar bien'],
            ],
            'Mocha' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Base de café'],
                ['ingredient' => 'Leche Entera', 'quantity' => 200, 'unit' => 'ml', 'notes' => 'Calentar'],
                ['ingredient' => 'Jarabe de Chocolate', 'quantity' => 30, 'unit' => 'ml', 'notes' => 'Mezclar antes de servir'],
                ['ingredient' => 'Crema Batida', 'quantity' => 20, 'unit' => 'g', 'notes' => 'Decoración final'],
            ],
            'Americano' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Espresso base'],
                ['ingredient' => 'Agua Caliente', 'quantity' => 200, 'unit' => 'ml', 'notes' => 'Agua a 85°C'],
            ],
            'Espresso' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 1, 'unit' => 'shots', 'notes' => 'Espresso simple'],
            ],
            'Chocolate' => [
                ['ingredient' => 'Leche Entera', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Calentar bien'],
                ['ingredient' => 'Chocolate en Polvo', 'quantity' => 40, 'unit' => 'g', 'notes' => 'Disolver completamente'],
                ['ingredient' => 'Crema Batida', 'quantity' => 15, 'unit' => 'g', 'notes' => 'Opcional'],
            ],
            'Matcha' => [
                ['ingredient' => 'Leche Entera', 'quantity' => 200, 'unit' => 'ml', 'notes' => 'Calentar a 70°C'],
                ['ingredient' => 'Matcha en Polvo', 'quantity' => 8, 'unit' => 'g', 'notes' => 'Batir hasta espumar'],
            ],
            'Chai' => [
                ['ingredient' => 'Concentrado de Chai', 'quantity' => 60, 'unit' => 'ml', 'notes' => 'Base especiada'],
                ['ingredient' => 'Leche Entera', 'quantity' => 180, 'unit' => 'ml', 'notes' => 'Calentar y mezclar'],
            ],
            'Té' => [
                ['ingredient' => 'Té Negro', 'quantity' => 1, 'unit' => 'sobres', 'notes' => 'Infusionar 4 minutos'],
                ['ingredient' => 'Agua Caliente', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Agua a 95°C'],
            ],
            'Tisanas' => [
                ['ingredient' => 'Manzanilla', 'quantity' => 1, 'unit' => 'sobres', 'notes' => 'Infusionar 5 minutos'],
                ['ingredient' => 'Agua Caliente', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Agua hirviendo'],
            ],
            'Latte frío' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Dejar enfriar'],
                ['ingredient' => 'Leche Entera', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Leche fría'],
                ['ingredient' => 'Hielo', 'quantity' => 8, 'unit' => 'cubos', 'notes' => 'Agregar al final'],
            ],
            'Capuccino frío' => [
                ['ingredient' => 'Café Espresso', 'quantity' => 2, 'unit' => 'shots', 'notes' => 'Enfriar antes de usar'],
                ['ingredient' => 'Leche Entera', 'quantity' => 150, 'unit' => 'ml', 'notes' => 'Leche fría espumada'],
                ['ingredient' => 'Hielo', 'quantity' => 6, 'unit' => 'cubos', 'notes' => 'Para servir'],
            ],
            'Chocolate Frio' => [
                ['ingredient' => 'Leche Entera', 'quantity' => 250, 'unit' => 'ml', 'notes' => 'Leche fría'],
                ['ingredient' => 'Chocolate en Polvo', 'quantity' => 35, 'unit' => 'g', 'notes' => 'Disolver bien'],
                ['ingredient' => 'Hielo', 'quantity' => 10, 'unit' => 'cubos', 'notes' => 'Para enfriar'],
                ['ingredient' => 'Crema Batida', 'quantity' => 20, 'unit' => 'g', 'notes' => 'Decoración'],
            ],
        ];

        // Crear las relaciones
        foreach ($recipes as $productName => $recipe) {
            $product = $products->get($productName);

            if (!$product) {
                continue; // Skip si el producto no existe
            }

            foreach ($recipe as $recipeItem) {
                $ingredient = $ingredients->get($recipeItem['ingredient']);

                if (!$ingredient) {
                    continue; // Skip si el ingrediente no existe
                }

                ProductIngredient::create([
                    'menu_product_id' => $product->id,
                    'ingredient_type' => Ingredient::class,
                    'ingredient_id' => $ingredient->id,
                    'quantity_needed' => $recipeItem['quantity'],
                    'unit' => $recipeItem['unit'],
                    'notes' => $recipeItem['notes'] ?? null,
                ]);
            }
        }

        // Crear algunos inventarios para opciones de personalización que consumen stock
        $this->createCustomizationInventories();
    }

    /**
     * Crear inventarios para opciones de personalización que consumen stock
     */
    private function createCustomizationInventories(): void
    {
        // Buscar opciones específicas que consumen inventario
        $customizationOptions = \App\Models\CustomizationOption::whereIn('name', [
            'Soya',
            'Deslactosada', // Tipos de leche especiales
            'Vainilla',
            'Caramelo',
            'Almendra',
            'Crema Irlandesa', // Jarabes
            'Shot Espresso',
            'Chocolate',
            'Crema Batida', // Extras
        ])->get();

        // Mapeo de opciones a ingredientes
        $optionToIngredient = [
            'Soya' => 'Leche de Soya',
            'Deslactosada' => 'Leche Deslactosada',
            'Vainilla' => 'Jarabe de Vainilla',
            'Caramelo' => 'Jarabe de Caramelo',
            'Almendra' => 'Jarabe de Almendra',
            'Crema Irlandesa' => 'Jarabe de Crema Irlandesa',
            'Shot Espresso' => 'Café Espresso',
            'Chocolate' => 'Jarabe de Chocolate',
            'Crema Batida' => 'Crema Batida',
        ];

        $ingredients = Ingredient::all()->keyBy('name');

        foreach ($customizationOptions as $option) {
            $ingredientName = $optionToIngredient[$option->name] ?? null;

            if ($ingredientName && $ingredients->has($ingredientName)) {
                // Verificar si ya existe inventario para esta opción
                $existingInventory = \App\Models\Inventory::where('stockable_type', \App\Models\CustomizationOption::class)
                    ->where('stockable_id', $option->id)
                    ->exists();

                if (!$existingInventory) {
                    // Crear inventario limitado para esta opción
                    \App\Models\Inventory::create([
                        'stockable_type' => \App\Models\CustomizationOption::class,
                        'stockable_id' => $option->id,
                        'stock' => rand(10, 50), // Stock limitado para opciones especiales
                        'min_stock' => 5,
                        'max_stock' => 100,
                    ]);
                }
            }
        }
    }
}