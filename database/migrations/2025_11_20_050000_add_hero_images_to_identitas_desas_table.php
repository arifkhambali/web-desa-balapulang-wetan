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
            $table->string('hero_image_beranda')->nullable();
            $table->string('hero_image_umkm')->nullable();
            $table->string('hero_image_pemerintahan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_desas', function (Blueprint $table) {
            $table->dropColumn('hero_image_beranda');
            $table->dropColumn('hero_image_umkm');
            $table->dropColumn('hero_image_pemerintahan');
        });
    }
};
