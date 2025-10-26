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
            $table->renameColumn('used_by', 'recorded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient_usage', function (Blueprint $table) {
            $table->renameColumn('recorded_by', 'used_by');
        });
    }
};
