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
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('order_id');
            $table->integer('customer_id')->nullable();
            $table->timestamp('order_date')->useCurrent();
            $table->enum('order_type', ['Walk-in', 'Advance', 'Bulk'])->nullable()->default('Walk-in');
            $table->enum('status', ['Pending', 'Confirmed', 'Completed', 'Cancelled'])->nullable()->default('Pending');
            $table->decimal('total_amount', 10)->nullable();
            $table->integer('handled_by')->nullable();
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
