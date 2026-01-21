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
        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->json('form_schema')->nullable()->after('template_html')
                  ->comment('JSON schema untuk dynamic form fields. Contoh: {"fields":[{"name":"nama_usaha","label":"Nama Usaha","type":"text","required":true}]}');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_surats', function (Blueprint $table) {
            $table->dropColumn('form_schema');
        });
    }
};
