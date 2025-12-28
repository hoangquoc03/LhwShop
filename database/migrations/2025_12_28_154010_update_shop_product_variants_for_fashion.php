<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop_product_variants', function (Blueprint $table) {
            $table->string('color', 50)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('image')->nullable();
        });

        // FIX dữ liệu cũ (tránh trùng unique)
        DB::statement("
        UPDATE shop_product_variants
        SET color = IFNULL(color, 'default'),
            size  = IFNULL(size, 'default')
    ");

        // Add unique sau khi data đã sạch
        Schema::table('shop_product_variants', function (Blueprint $table) {
            $table->unique(
                ['product_id', 'color', 'size'],
                'product_color_size_unique'
            );
        });
    }



    public function down(): void
    {
        Schema::table('shop_product_variants', function (Blueprint $table) {
            $table->dropUnique('product_color_size_unique');
            $table->dropColumn(['color', 'size', 'image']);
        });
    }
};
