<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuCategory::create([
            'id' => 1001,
            'name' => 'Bebidas Calientes',
            'description' => 'Bebidas en base de café y sin café'
        ]);

        MenuCategory::create([
            'id' => 1002,
            'name' => 'Bebidas Frias',
            'description' => 'Bebidas en base de café y sin café'
        ]);

        MenuCategory::create([
            'id' => 1003,
            'name' => 'Alimentos',
            'description' => 'Paninis y postres'
        ]);
    }
}
