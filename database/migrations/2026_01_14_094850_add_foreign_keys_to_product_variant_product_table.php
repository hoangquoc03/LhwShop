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
        Schema::table('product_variant_product', function (Blueprint $table) {

            // FK product_id -> shop_products.id
            $table->foreign('product_id')
                ->references('id')
                ->on('shop_products')
                ->cascadeOnDelete();

            // FK variant_id -> shop_product_variants.id
            $table->foreign('variant_id')
                ->references('id')
                ->on('shop_product_variants')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variant_product', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['variant_id']);
        });
    }
};