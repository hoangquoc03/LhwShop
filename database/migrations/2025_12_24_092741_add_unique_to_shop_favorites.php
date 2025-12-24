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
        Schema::table('shop_favorites', function (Blueprint $table) {
            $table->unique(['customer_id', 'product_id'], 'shop_favorites_unique_customer_product');
        });
    }

    public function down(): void
    {
        Schema::table('shop_favorites', function (Blueprint $table) {
            $table->dropUnique('shop_favorites_unique_customer_product');
        });
    }
};
