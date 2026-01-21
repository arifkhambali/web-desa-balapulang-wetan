<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackfillPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Penduduk::whereNull('golongan_darah')->get()->each(function($p) {
            $p->update([
                'golongan_darah' => collect(['A', 'B', 'AB', 'O', '-'])->random(),
                'kewarganegaraan' => 'WNI'
            ]);
        });
    }
}
