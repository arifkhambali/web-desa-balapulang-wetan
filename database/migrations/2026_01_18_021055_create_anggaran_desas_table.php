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
        Schema::create('anggaran_desas', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->enum('jenis', ['pendapatan', 'belanja', 'pembiayaan']);
            $table->string('kategori');
            $table->decimal('nominal', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_desas');
    }
};
