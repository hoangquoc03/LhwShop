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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_code',50);
            $table->text('product_name',500);
            $table->text('image');
            $table->text('short_description',250);
            $table->mediumText('description');
            $table->decimal('standard_cost',16,0);
            $table->decimal('list_price',16,0);
            $table->integer('quantity_per_unit');
            $table->boolean('discontinued');
            $table->boolean('is_featured');
            $table->boolean('is_new');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->timestamps();
            // references
            $table->foreign('category_id')->references('id')->on('shop_categories');
            $table->foreign('supplier_id')->references('id')->on('shop_suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};