<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IdentitasDesa;

class IdentitasDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (IdentitasDesa::count() === 0) {
            IdentitasDesa::create([
                'nama_desa' => 'Desa Tundagan',
                'alamat' => 'Jl. Raya Desa Tundagan No. 1, Kec. Sejahtera, Kab. Makmur, Jawa Barat 45362',
                'email' => 'admin@desamajujaya.go.id',
                'telepon' => '(022) 1234-5678',
                'jam_pelayanan' => '<p><strong>Senin - Kamis</strong><br>08.00 - 15.00 WIB</p><p><strong>Jumat</strong><br>08.00 - 11.00 WIB</p><p><strong>Sabtu - Minggu</strong><br><span style="color: rgb(239, 68, 68);">Libur</span></p>',
                'facebook' => 'desamajujaya',
                'instagram' => 'desamajujaya',
                'youtube' => 'desamajujaya',
                'twitter' => 'desamajujaya',
            ]);
        }
    }
}
