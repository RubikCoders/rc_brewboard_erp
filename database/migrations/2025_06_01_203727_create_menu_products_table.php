<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_products', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->json('ingredients')->nullable();
            $table->integer('base_price');
            $table->integer('estimated_time_min');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('menu_categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_products');
    }
};
