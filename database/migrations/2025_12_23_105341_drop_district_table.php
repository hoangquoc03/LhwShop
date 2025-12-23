<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bỏ foreign key trước
        Schema::table('wards', function (Blueprint $table) {
            $table->dropForeign(['district_id']); // tên cột
            $table->dropColumn('district_id');   // xóa cột luôn
        });

        // Drop bảng districts
        Schema::dropIfExists('districts');
    }

    public function down(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('wards', function (Blueprint $table) {
            $table->foreignId('district_id')->constrained()->onDelete('cascade');
        });
    }
};
