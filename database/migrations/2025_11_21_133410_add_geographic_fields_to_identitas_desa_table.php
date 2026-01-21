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
        Schema::table('identitas_desas', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('logo');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('batas_utara')->nullable()->after('longitude');
            $table->string('batas_timur')->nullable()->after('batas_utara');
            $table->string('batas_selatan')->nullable()->after('batas_timur');
            $table->string('batas_barat')->nullable()->after('batas_selatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_desas', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'batas_utara',
                'batas_timur',
                'batas_selatan',
                'batas_barat',
            ]);
        });
    }
};

