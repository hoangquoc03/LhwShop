<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {

            $table->timestamp('paid_at')
                ->nullable()
                ->after('payment_status');

            $table->string('sepay_transaction_id', 100)
                ->nullable()
                ->unique()
                ->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropUnique(['sepay_transaction_id']);

            $table->dropColumn([
                'paid_at',
                'sepay_transaction_id',
            ]);
        });
    }
};