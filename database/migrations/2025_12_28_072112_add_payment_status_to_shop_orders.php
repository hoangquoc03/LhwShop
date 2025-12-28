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
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->string('payment_status')
                ->default('unpaid')
                ->after('payment_type_id');

            $table->string('vnp_txn_ref')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            //
        });
    }
};
