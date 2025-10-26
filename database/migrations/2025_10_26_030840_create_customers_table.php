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
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customer_id');
            $table->string('name', 100);
            $table->string('contact_number', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->enum('customer_type', ['Regular', 'Bulk Buyer', 'VIP'])->nullable()->default('Regular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
