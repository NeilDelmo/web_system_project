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
           Schema::table('ingredient_usage', function (Blueprint $table) {
            // Use regular dropForeign with the constraint name
            $table->dropForeign(['ingredient_id']);
        });

        // Change ingredients.ingredient_id to bigint unsigned to match ingredient_usage
        Schema::table('ingredients', function (Blueprint $table) {
            $table->integer('ingredient_id')->change();
        });

        // Now add the foreign key constraint
        Schema::table('ingredient_usage', function (Blueprint $table) {
            $table->foreign('ingredient_id')
                  ->references('ingredient_id')
                  ->on('ingredients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
          Schema::table('ingredient_usage', function (Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
        });

        // Revert ingredients.ingredient_id back to int
        Schema::table('ingredients', function (Blueprint $table) {
            $table->integer('ingredient_id')->change();
        });

    }
};
