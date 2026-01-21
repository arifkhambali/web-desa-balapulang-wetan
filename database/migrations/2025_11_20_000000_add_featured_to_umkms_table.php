<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->boolean('aktif')->default(true);
            $table->boolean('featured')->default(false);
        });
    }

    public function down()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['aktif', 'featured']);
        });
    }
};
