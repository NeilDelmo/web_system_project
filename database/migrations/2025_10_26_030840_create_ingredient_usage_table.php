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
        Schema::create('ingredient_usage', function (Blueprint $table) {
            $table->integer('usage_id');
            $table->integer('ingredient_id')->nullable();
            $table->integer('used_by')->nullable();
            $table->decimal('quantity_used', 10)->nullable();
            $table->timestamp('usage_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_usage');
    }
};
