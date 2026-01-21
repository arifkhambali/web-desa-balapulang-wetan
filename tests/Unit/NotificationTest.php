<?php

namespace Tests\Unit;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\User;
use App\Notifications\NewSuratSubmitted;
use App\Notifications\SuratStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_surat_status_changed_notification_format()
    {
        $user = User::factory()->create();
        $jenisSurat = JenisSurat::factory()->create(['nama_surat' => 'Surat Keterangan']);
        $surat = PengajuanSurat::factory()->create([
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
        ]);

        $notification = new SuratStatusChanged($surat, 'pending', 'diproses');
        
        // Assert via method returns database
        $this->assertEquals(['database'], $notification->via($user));

        // Assert toDatabase returns correct structure
        $data = $notification->toDatabase($user);
        
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals('Status Surat Berubah', $data['title']);
        // Status 'diproses' labelnya 'Sedang Diproses'
        $this->assertStringContainsString('Sedang Diproses', $data['body']);
        $this->assertArrayHasKey('actions', $data);
    }

    public function test_new_surat_submitted_notification_format()
    {
        $user = User::factory()->create(['name' => 'Budi']);
        $jenisSurat = JenisSurat::factory()->create(['nama_surat' => 'Surat Pengantar']);
        $surat = PengajuanSurat::factory()->create([
            'user_id' => $user->id,
            'jenis_surat_id' => $jenisSurat->id,
        ]);

        $notification = new NewSuratSubmitted($surat);
        
        $data = $notification->toDatabase($user); // Admin user
        
        $this->assertEquals('Pengajuan Surat Baru', $data['title']);
        $this->assertStringContainsString('Budi', $data['body']);
        $this->assertStringContainsString('Surat Pengantar', $data['body']);
    }
}
