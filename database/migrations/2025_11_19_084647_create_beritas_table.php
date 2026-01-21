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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['Pemerintahan', 'Kesehatan', 'Sosial', 'Ekonomi', 'Pertanian', 'Budaya', 'Lainnya'])->default('Lainnya');
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->string('penulis')->default('Admin');
            $table->integer('views')->default(0);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
