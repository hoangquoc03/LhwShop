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
            if (!Schema::hasColumn('wards', 'city_id')) {
                $table->foreignId('city_id')
                    ->after('id')
                    ->constrained('cities')
                    ->cascadeOnDelete();
            }
        });

        if (Schema::hasColumn('wards', 'district_id')) {
            Schema::table('wards', function (Blueprint $table) {
                $table->dropColumn('district_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wards', function (Blueprint $table) {
            if (!Schema::hasColumn('wards', 'district_id')) {
                $table->unsignedBigInteger('district_id')->nullable();
            }

            if (Schema::hasColumn('wards', 'city_id')) {
                $table->dropConstrainedForeignId('city_id');
            }
        });
    }
};
