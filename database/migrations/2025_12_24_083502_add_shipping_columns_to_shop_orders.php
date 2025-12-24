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
        Schema::table('shop_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('shop_orders', 'ship_name')) {
                $table->string('ship_name')->nullable();
            }

            if (!Schema::hasColumn('shop_orders', 'ship_phone')) {
                $table->string('ship_phone')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropColumn(['ship_name', 'ship_phone']);
        });
    }
};
