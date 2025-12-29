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
        Schema::table('shop_carts', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_carts', 'variant_id')) {
                $table->unsignedBigInteger('variant_id')
                    ->nullable()
                    ->after('product_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('shop_carts', function (Blueprint $table) {
            if (Schema::hasColumn('shop_carts', 'variant_id')) {
                $table->dropColumn('variant_id');
            }
        });
    }
};
