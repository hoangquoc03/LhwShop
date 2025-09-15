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
        Schema::create('shop_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',200);
            $table->string('password',200);
            $table->string('last_name',200);
            $table->string('first_name',200);
            $table->boolean('gender');
            $table->string('email',191);
            $table->dateTime('birthday');
            $table->string('avatar',500);
            $table->string('code',500);
            $table->string('company',500);
            $table->string('phone',25);
            $table->string('billing_address',500);
            $table->string('shipping_address',500);
            $table->string('city',500);
            $table->string('state',500);
            $table->string('postal_code',20);
            $table->string('country',500);
            $table->string('remember_token',200);
            $table->string('activate_code',200);
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_customers');
    }
};