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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->enum('kategori', ['Makanan', 'Kerajinan', 'Pertanian', 'Lainnya'])->default('Lainnya');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->string('gambar')->nullable();
            $table->string('nama_penjual');
            $table->string('kontak');
            $table->enum('status', ['tersedia', 'pre-order', 'habis'])->default('tersedia');
            $table->integer('stok')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('kategori');
            $table->index('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
