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
        Schema::create('shop_posts', function (Blueprint $table) {
            $table->bigIncrements('id');

    $table->text('post_slug');
    $table->text('post_title');
    $table->mediumText('post_content');
    $table->mediumText('post_excerpt')->nullable();

    $table->string('post_type', 500);
    $table->string('post_status', 500);
    $table->mediumText('post_image')->nullable();

    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('post_category_id');

    $table->timestamps();

    $table->foreign('user_id')
          ->references('id')
          ->on('acl_users')
          ->onDelete('cascade');

    $table->foreign('post_category_id')
          ->references('id')
          ->on('shop_post_categories')
          ->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_posts');
    }
};