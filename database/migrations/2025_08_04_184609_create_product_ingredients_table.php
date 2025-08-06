<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('menu_product_id')->constrained('menu_products')->onDelete('cascade');
            $table->morphs('ingredient');
            $table->decimal('quantity_needed', 8, 2);
            $table->string('unit');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Índices para optimización
            $table->index(['menu_product_id']);
            $table->index(
                ['ingredient_type', 'ingredient_id'],
                'idx_prod_ingr_type_ingr'
            );

            // Constraint único para evitar duplicados
            $table->unique(['menu_product_id', 'ingredient_type', 'ingredient_id'], 'unique_product_ingredient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_ingredients');
    }
};