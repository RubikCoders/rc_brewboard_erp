<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EmployeeRoleSeeder::class,
            EmployeeSeeder::class,
            MenuCategorySeeder::class,
            MenuProductSeeder::class,
            ProductCustomizationSeeder::class,
            CustomizationOptionSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
            OrderCustomizationSeeder::class,
            IngredientSeeder::class,
            ProductIngredientSeeder::class,
            OrderReviewSeeder::class
        ]);
    }
}
