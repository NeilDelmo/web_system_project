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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->integer('ingredient_id');
            $table->string('name', 100);
            $table->string('category', 50)->nullable();
            $table->string('unit', 20)->nullable();
            $table->decimal('quantity', 10)->nullable()->default(0);
            $table->decimal('reorder_level', 10)->nullable();
            $table->enum('storage_location', ['Pantry', 'Freezer', 'Refrigerator']);
            $table->enum('status', ['Available', 'Low Stock', 'Out of Stock'])->nullable()->default('Available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
