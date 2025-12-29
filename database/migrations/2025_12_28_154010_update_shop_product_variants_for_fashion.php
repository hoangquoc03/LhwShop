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

            if (!Schema::hasColumn('shop_product_variants', 'color')) {
                $table->string('color', 50)->nullable();
            }

            if (!Schema::hasColumn('shop_product_variants', 'size')) {
                $table->string('size', 20)->nullable();
            }

            if (!Schema::hasColumn('shop_product_variants', 'image')) {
                $table->string('image')->nullable();
            }
        });

        // Chuẩn hóa data cũ
        DB::statement("
            UPDATE shop_product_variants
            SET color = IFNULL(color, 'default'),
                size  = IFNULL(size, 'default')
        ");

        // Add unique nếu chưa tồn tại
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

            if (Schema::hasColumn('shop_product_variants', 'color')) {
                $table->dropColumn('color');
            }

            if (Schema::hasColumn('shop_product_variants', 'size')) {
                $table->dropColumn('size');
            }

            if (Schema::hasColumn('shop_product_variants', 'image')) {
                $table->dropColumn('image');
            }

            $table->dropUnique('product_color_size_unique');
        });
    }
};
