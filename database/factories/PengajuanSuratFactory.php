<?php

namespace Database\Factories;

use App\Models\JenisSurat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanSuratFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'jenis_surat_id' => JenisSurat::factory(),
            'nomor_surat' => null,
            'status' => 'pending',
            'data_pemohon' => [
                'nama' => $this->faker->name(),
                'nik' => $this->faker->numerify('################'),
                'alamat' => $this->faker->address(),
            ],
            'lampiran' => [],
            'catatan_admin' => null,
            'tanggal_pengajuan' => now(),
            'tanggal_selesai' => null,
        ];
    }
}
