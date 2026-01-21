<?php

namespace Tests\Feature;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengajuanSuratTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_pengajuan_surat()
    {
        $user = User::factory()->create(['role' => 'warga']);
        $jenisSurat = JenisSurat::factory()->create();

        $data = [
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
            'status' => 'pending',
            'data_pemohon' => [
                'nama' => 'Test Warga',
                'nik' => '1234567890123456',
                'alamat' => 'Jl. Test No. 1',
            ],
            'tanggal_pengajuan' => now(),
        ];

        $surat = PengajuanSurat::create($data);

        $this->assertDatabaseHas('pengajuan_surats', [
            'id' => $surat->id,
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $this->assertEquals('Test Warga', $surat->data_pemohon['nama']);
    }

    public function test_surat_belongs_to_user()
    {
        $user = User::factory()->create();
        $surat = PengajuanSurat::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($surat->user->is($user));
    }

    public function test_surat_belongs_to_jenis_surat()
    {
        $jenis = JenisSurat::factory()->create();
        $surat = PengajuanSurat::factory()->create(['jenis_surat_id' => $jenis->id]);

        $this->assertTrue($surat->jenisSurat->is($jenis));
    }
}
