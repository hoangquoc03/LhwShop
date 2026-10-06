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
        Schema::table('shop_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_posts', 'product_id')) {
                $table->foreignId('product_id')
                    ->after('id')
                    ->constrained('shop_products')
                    ->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_posts', function (Blueprint $table) {
            if (Schema::hasColumn('shop_posts', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }
        });
    }
};
