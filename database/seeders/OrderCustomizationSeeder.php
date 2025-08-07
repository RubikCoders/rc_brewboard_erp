<?php

namespace Database\Seeders;

use App\Models\OrderCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderCustomization::factory()->count(10000)->create();
    }
}
