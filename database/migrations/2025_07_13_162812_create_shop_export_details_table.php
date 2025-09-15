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
        Schema::create('shop_export_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('export_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity',18,0);
            $table->decimal('unit_price',19,0);
            $table->unsignedBigInteger('import_detail_id');
            $table->foreign('export_id')->references('id')->on('shop_exports');
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('import_detail_id')->references('id')->on('shop_import_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_export_details');
    }
};