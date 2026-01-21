<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw SQL to modify ENUM because Doctrine DBAL might not be available or reliable for ENUMs
        DB::statement("ALTER TABLE pengajuan_surats MODIFY COLUMN status ENUM('pending', 'diproses', 'menunggu_persetujuan', 'selesai', 'ditolak') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pengajuan_surats MODIFY COLUMN status ENUM('pending', 'diproses', 'selesai', 'ditolak') DEFAULT 'pending'");
    }
};
