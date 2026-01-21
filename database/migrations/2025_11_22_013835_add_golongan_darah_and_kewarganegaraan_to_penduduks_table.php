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
        Schema::table('penduduks', function (Blueprint $table) {
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', '-'])->nullable()->after('agama');
            $table->enum('kewarganegaraan', ['WNI', 'WNA'])->default('WNI')->after('status_perkawinan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropColumn(['golongan_darah', 'kewarganegaraan']);
        });
    }
};
