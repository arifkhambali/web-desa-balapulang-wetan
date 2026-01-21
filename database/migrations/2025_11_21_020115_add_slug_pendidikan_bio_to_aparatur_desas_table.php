<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aparatur_desas', function (Blueprint $table) {
            if (!Schema::hasColumn('aparatur_desas', 'slug')) {
                $table->string('slug')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('aparatur_desas', 'pendidikan')) {
                $table->string('pendidikan')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('aparatur_desas', 'bio')) {
                $table->text('bio')->nullable()->after('pendidikan');
            }
        });

        // Generate slugs for existing records
        $aparaturs = \DB::table('aparatur_desas')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($aparaturs as $aparatur) {
            $slug = Str::slug($aparatur->nama);
            \DB::table('aparatur_desas')
                ->where('id', $aparatur->id)
                ->update(['slug' => $slug]);
        }

        // Add unique constraint to slug if not exists
        try {
            Schema::table('aparatur_desas', function (Blueprint $table) {
                $table->unique('slug');
            });
        } catch (\Exception $e) {
            // Unique constraint already exists, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aparatur_desas', function (Blueprint $table) {
            if (Schema::hasColumn('aparatur_desas', 'slug')) {
                try {
                    $table->dropUnique(['slug']);
                } catch (\Exception $e) {
                    // Ignore if constraint doesn't exist
                }
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('aparatur_desas', 'pendidikan')) {
                $table->dropColumn('pendidikan');
            }
            if (Schema::hasColumn('aparatur_desas', 'bio')) {
                $table->dropColumn('bio');
            }
        });
    }
};
