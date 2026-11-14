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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_street')->nullable();
            $table->string('shipping_house_number', 10)->nullable();
            $table->string('shipping_postcode', 6)->nullable();
            $table->string('shipping_city')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_street', 'shipping_house_number', 'shipping_postcode', 'shipping_city']);
        });
    }
};
