<?php

namespace Database\Seeders;

use App\Models\OrderProductCustomization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderProductCustomizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderProductCustomization::factory()->count(5000)->create();
    }
}
