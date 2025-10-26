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
      // Ensure parent column has an index for FK reference
      Schema::table('ingredients', function (Blueprint $table) {
        // Add an index on ingredient_id if one doesn't already exist
        // MySQL will ignore duplicate index creation attempts
        $table->index('ingredient_id', 'ingredients_ingredient_id_index');
      });

      Schema::table('ingredient_usage', function (Blueprint $table) {
        // Keep everything as plain integer (no unsigned/bigint), per project preference
        $table->integer('ingredient_id')->change();
        $table->integer('recorded_by')->nullable()->change();

        // Add foreign keys with matching types
        $table->foreign('ingredient_id', 'ingredient_usage_ingredient_id_fk')
            ->references('ingredient_id')
            ->on('ingredients')
            ->onDelete('cascade');

        $table->foreign('recorded_by', 'ingredient_usage_recorded_by_fk')
            ->references('user_id')
            ->on('system_users')
            ->onDelete('set null');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient_usage', function (Blueprint $table) {
            $table->dropForeign('ingredient_usage_ingredient_id_fk');
            $table->dropForeign('ingredient_usage_recorded_by_fk');

            // Optionally revert to plain int without unsigned
            // $table->integer('ingredient_id')->change();
            // $table->integer('recorded_by')->nullable()->change();
        });
    }
};