<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformasiPublikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['SOP', 'Realisasi', 'Struktur', 'Laporan', 'SK', 'Peraturan'];
        $units = ['Superadmin', 'Sekretariat Desa', 'BPD', 'LPMD'];

        for ($i = 1; $i <= 50; $i++) {
            $type = $types[array_rand($types)];
            $judul = "{$type} Informasi Publik Nomor {$i} Tahun 2024";
            
            \App\Models\InformasiPublik::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($judul)],
                [
                    'judul' => $judul,
                    'file_path' => 'informasi-publik/sample-file.pdf',
                    'tgl_terbit' => now()->subDays(rand(1, 365)),
                    'unit_pengelola' => $units[array_rand($units)],
                ]
            );
        }
    }
}
