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
        Schema::create('product_customizations_options', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('customization_id');
            $table->string('name');
            $table->integer('extra_price')->default(0);
            $table->timestamps();

            $table->foreign('customization_id')->references('id')->on('product_customizations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_customizations_options');
    }
};
