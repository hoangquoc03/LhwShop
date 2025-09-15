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
        Schema::create('acl_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 200);
            $table->string('password', 200);
            $table->string('last_name', 200);
            $table->string('first_name', 200);
            $table->boolean('gender');
            $table->string('email', 191);
            $table->dateTime('birthday')->nullable();
            $table->string('avatar', 500)->nullable();
            $table->string('code', 500)->nullable();
            $table->string('job_title', 500)->nullable();
            $table->string('department', 500)->nullable();
            $table->unsignedBigInteger('manager_id')->nullable(); 
            $table->string('phone', 25)->nullable();
            $table->string('address1', 500)->nullable();
            $table->string('address2', 500)->nullable();
            $table->string('city', 500)->nullable();
            $table->string('state', 500)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 500)->nullable();
            $table->string('remember_token', 200)->nullable();
            $table->string('active_code', 200)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acl_users');
    }
};