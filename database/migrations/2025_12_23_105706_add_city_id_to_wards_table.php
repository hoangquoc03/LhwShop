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
        Schema::table('wards', function (Blueprint $table) {
            $table->foreignId('city_id')->after('id')->constrained()->onDelete('cascade');
            $table->dropColumn('district_id'); // xóa district_id
        });
    }

    public function down(): void
    {
        Schema::table('wards', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable();
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
};
