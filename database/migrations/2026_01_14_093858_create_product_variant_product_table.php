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
        Schema::create('product_variant_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('shop_products')
                ->cascadeOnDelete();

            $table->foreignId('variant_id')
                ->constrained('shop_product_variants') // 🔥 SỬA Ở ĐÂY
                ->cascadeOnDelete();

            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity')->default(0);

            $table->timestamps();

            $table->unique(['product_id', 'variant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_product');
    }
};