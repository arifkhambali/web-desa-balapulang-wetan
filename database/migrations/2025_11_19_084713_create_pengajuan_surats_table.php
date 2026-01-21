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
        Schema::create('pengajuan_surats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained()->onDelete('cascade');
            $table->string('nomor_surat')->unique()->nullable();
            $table->json('data_pemohon'); // Data pemohon (NIK, nama, alamat, dll)
            $table->json('lampiran')->nullable(); // File KTP, KK, dll
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->string('file_surat')->nullable(); // File PDF surat yang sudah jadi
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('jenis_surat_id');
            $table->index('status');
            $table->index('nomor_surat');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surats');
    }
};
