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
        Schema::create('shop_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            $table->decimal('quantity', 18, 0);
            $table->decimal('unit_price', 19, 0);

            $table->float('discount_percentage')->default(0);
            $table->double('discount_amount')->default(0);

            $table->string('order_detail_status', 50)->nullable();
            $table->dateTime('date_allocated')->nullable();

            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('product_id')->references('id')->on('shop_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_order_details');
    }
};