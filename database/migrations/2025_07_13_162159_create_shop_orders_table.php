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
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();

            $table->dateTime('order_date')->nullable();
            $table->dateTime('shipped_date')->nullable();
            $table->string('ship_name', 50)->nullable();
            $table->string('ship_address1', 500)->nullable();
            $table->string('ship_address2', 500)->nullable();
            $table->string('ship_city', 255)->nullable();
            $table->string('ship_state', 255)->nullable();
            $table->string('ship_postal_code', 50)->nullable();
            $table->string('ship_country', 255)->nullable();

            $table->decimal('shipping_fee', 19, 0)->default(0);

            $table->unsignedBigInteger('payment_type_id')->nullable(); // Chú ý lỗi chính tả có thể là "payment_type_id"
            $table->dateTime('paid_date')->nullable();
            $table->string('order_status', 50)->nullable();

            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('acl_users');
            $table->foreign('customer_id')->references('id')->on('shop_customers');
            $table->foreign('payment_type_id')->references('id')->on('shop_payment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_orders');
    }
};