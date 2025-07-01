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
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->string('customer_name');
            $table->integer('total'); // In cents
            $table->integer('tax'); // In cents
            $table->string('payment_method');
            $table->enum('from', ['erp', 'csp']);
            $table->tinyInteger('status');
            // 0 - pendiente
            // 1 - pagada
            // 2 - cancelada
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
