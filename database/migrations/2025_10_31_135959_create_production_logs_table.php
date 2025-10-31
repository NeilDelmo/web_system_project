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
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity_produced');
            $table->json('ingredients_used'); // Store array of ingredient_id, quantity, unit
            $table->enum('status', ['completed', 'failed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->foreignId('produced_by')->nullable()->constrained('users')->onDelete('set null'); // Who produced it
            $table->timestamp('produced_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_logs');
    }
};
