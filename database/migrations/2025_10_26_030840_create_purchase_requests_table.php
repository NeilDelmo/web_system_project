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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->integer('request_id');
            $table->integer('ingredient_id')->nullable();
            $table->integer('requested_by')->nullable();
            $table->decimal('quantity_requested', 10)->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->nullable()->default('Pending');
            $table->timestamp('date_requested')->useCurrent();
            $table->integer('approved_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
