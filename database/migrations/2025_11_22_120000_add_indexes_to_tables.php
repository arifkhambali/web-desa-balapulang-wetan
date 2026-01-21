<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Berita indexes
        Schema::table('beritas', function (Blueprint $table) {
            if (!Schema::hasIndex('beritas', 'beritas_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('beritas', 'beritas_kategori_index')) {
                $table->index('kategori');
            }
            if (!Schema::hasIndex('beritas', 'beritas_created_at_kategori_index')) {
                $table->index(['created_at', 'kategori']);
            }
            if (!Schema::hasIndex('beritas', 'beritas_judul_konten_fulltext')) {
                $table->fullText(['judul', 'konten']);
            }
        });
        
        // UMKM indexes
        Schema::table('umkms', function (Blueprint $table) {
            if (!Schema::hasIndex('umkms', 'umkms_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('umkms', 'umkms_harga_index')) {
                $table->index('harga');
            }
            if (!Schema::hasIndex('umkms', 'umkms_kategori_harga_index')) {
                $table->index(['kategori', 'harga']);
            }
            if (!Schema::hasIndex('umkms', 'umkms_nama_produk_deskripsi_fulltext')) {
                $table->fullText(['nama_produk', 'deskripsi']);
            }
        });
        
        // Galeri indexes
        Schema::table('galeris', function (Blueprint $table) {
            if (!Schema::hasIndex('galeris', 'galeris_created_at_index')) {
                $table->index('created_at');
            }
            if (!Schema::hasIndex('galeris', 'galeris_judul_deskripsi_fulltext')) {
                $table->fullText(['judul', 'deskripsi']);
            }
        });
        
        // Penduduk indexes
        Schema::table('penduduks', function (Blueprint $table) {
            if (!Schema::hasIndex('penduduks', 'penduduks_nik_index')) {
                $table->index('nik');
            }
            if (!Schema::hasIndex('penduduks', 'penduduks_no_kk_index')) {
                $table->index('no_kk');
            }
            if (!Schema::hasIndex('penduduks', 'penduduks_jenis_kelamin_index')) {
                $table->index('jenis_kelamin');
            }
            if (!Schema::hasIndex('penduduks', 'penduduks_agama_index')) {
                $table->index('agama');
            }
            if (!Schema::hasIndex('penduduks', 'penduduks_status_hidup_index')) {
                $table->index('status_hidup');
            }
        });
        
        // PengajuanSurat indexes
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            if (!Schema::hasIndex('pengajuan_surats', 'pengajuan_surats_user_id_index')) {
                $table->index('user_id');
            }
            if (!Schema::hasIndex('pengajuan_surats', 'pengajuan_surats_jenis_surat_id_index')) {
                $table->index('jenis_surat_id');
            }
            if (!Schema::hasIndex('pengajuan_surats', 'pengajuan_surats_status_index')) {
                $table->index('status');
            }
            if (!Schema::hasIndex('pengajuan_surats', 'pengajuan_surats_created_at_index')) {
                $table->index('created_at');
            }
        });
    }

    public function down()
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['kategori']);
            $table->dropIndex(['created_at', 'kategori']);
            $table->dropFullText(['judul', 'konten']);
        });
        
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['harga']);
            $table->dropIndex(['kategori', 'harga']);
            $table->dropFullText(['nama_produk', 'deskripsi']);
        });
        
        Schema::table('galeris', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropFullText(['judul', 'deskripsi']);
        });
        
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropIndex(['nik']);
            $table->dropIndex(['no_kk']);
            $table->dropIndex(['jenis_kelamin']);
            $table->dropIndex(['agama']);
            $table->dropIndex(['status_hidup']);
        });
        
        Schema::table('pengajuan_surats', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['jenis_surat_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
    }
};
