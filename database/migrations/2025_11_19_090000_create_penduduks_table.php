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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya']);
            $table->enum('pendidikan_terakhir', ['Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan');
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']);
            $table->enum('status_keluarga', ['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Cucu', 'Orang Tua', 'Mertua', 'Famili Lain', 'Pembantu', 'Lainnya']);
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('desa_kelurahan')->default('Maju Jaya');
            $table->string('kecamatan')->default('Sejahtera');
            $table->string('kabupaten_kota')->default('Makmur');
            $table->string('provinsi')->default('Jawa Tengah');
            $table->enum('status_hidup', ['Hidup', 'Meninggal', 'Pindah'])->default('Hidup');
            $table->softDeletes(); // Soft Delete
            $table->timestamps();

            $table->index('nik');
            $table->index('no_kk');
            $table->index('nama_lengkap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
