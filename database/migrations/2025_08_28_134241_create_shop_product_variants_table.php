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
        Schema::create('shop_product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku', 100)->unique();          // mã hàng riêng cho từng biến thể
            $table->string('variant_name')->nullable();    // vd: "Đen / i7 / 16GB"
            $table->decimal('price', 19, 2)->nullable();   // giá bán của biến thể (nếu khác sản phẩm gốc)
            $table->integer('stock_quantity')->default(0); // tồn kho cho biến thể
            $table->json('options')->nullable();     
            $table->bigInteger('product_id')->unsigned();      // JSON mô tả thuộc tính: {"Màu":"Đen","CPU":"i7","RAM":"16GB"}
            $table->boolean('is_active')->default(true);   // cho phép bán hay không
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_product_variants');
    }
};