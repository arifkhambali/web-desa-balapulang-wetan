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
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar');
            $table->enum('kategori', ['Kegiatan', 'Infrastruktur', 'Budaya', 'Lainnya'])->default('Lainnya');
            $table->date('tanggal_kegiatan')->nullable();
            $table->timestamps();
            
            $table->index('kategori');
            $table->index('tanggal_kegiatan');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
