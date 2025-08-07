<?php

namespace Database\Seeders;

use App\Models\OrderReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderReview::factory()->count(250)->create();
    }
}
