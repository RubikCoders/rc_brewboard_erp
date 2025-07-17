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
        Schema::create('order_customizations', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('order_product_id');
            $table->foreignId('product_customization_id');
            $table->timestamps();

            $table->foreign('order_product_id')->references('id')->on('order_products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_customization_id')->references('id')->on('customizations_options')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_customizations');
    }
};
