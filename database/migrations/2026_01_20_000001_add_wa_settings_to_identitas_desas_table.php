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
        Schema::table('identitas_desas', function (Blueprint $table) {
            $table->string('wa_api_url')->nullable();
            $table->string('wa_api_key')->nullable();
            $table->string('wa_sender_number')->nullable();
            $table->text('wa_template_pengajuan')->nullable();
            $table->text('wa_template_update_status')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('telepon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'telepon')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('telepon');
            });
        }

        if (Schema::hasColumn('penduduks', 'telepon')) {
            Schema::table('penduduks', function (Blueprint $table) {
                $table->dropColumn('telepon');
            });
        }

        Schema::table('identitas_desas', function (Blueprint $table) {
            $cols = [
                'wa_api_url',
                'wa_api_key',
                'wa_sender_number',
                'wa_template_pengajuan',
                'wa_template_update_status',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('identitas_desas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
