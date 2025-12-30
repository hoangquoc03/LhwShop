<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('shop_order_details', function (Blueprint $table) {

            // ⚠️ nếu bảng đã có dữ liệu → PHẢI nullable
            $table->unsignedBigInteger('variant_id')
                ->nullable()
                ->after('product_id');

            // tạo khóa ngoại
            $table->foreign('variant_id')
                ->references('id')
                ->on('shop_product_variants')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('shop_order_details', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};
