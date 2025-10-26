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
            $table->unsignedBigInteger('ingredient_id')->change();
            $table->unsignedBigInteger('recorded_by')->nullable()->change(); // optional: add nullable if needed

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('set null');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient_usage', function (Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
            $table->dropForeign(['recorded_by']);
        });
    }
};
