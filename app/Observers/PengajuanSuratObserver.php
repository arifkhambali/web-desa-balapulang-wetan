<?php

namespace App\Observers;

use App\Models\PengajuanSurat;
use App\Models\IdentitasDesa;
use App\Notifications\StatusSuratNotification;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class PengajuanSuratObserver
{
    /**
     * Handle the PengajuanSurat "created" event.
     */
    public function created(PengajuanSurat $pengajuanSurat): void
    {
        // Email Notification
        if ($pengajuanSurat->user) {
            $pengajuanSurat->user->notify(new StatusSuratNotification($pengajuanSurat));
        }

        // WhatsApp Notification
        $this->sendWhatsAppNotification($pengajuanSurat, 'created');
    }

    /**
     * Handle the PengajuanSurat "updated" event.
     */
    public function updated(PengajuanSurat $pengajuanSurat): void
    {
        // Check if status attribute was changed in the last update
        if ($pengajuanSurat->wasChanged('status')) {
            // Send Email notification
            if ($pengajuanSurat->user && $pengajuanSurat->user->email) {
                try {
                    $pengajuanSurat->user->notify(new StatusSuratNotification($pengajuanSurat));
                } catch (\Exception $e) {
                    Log::warning('Gagal mengirim email notifikasi update: ' . $e->getMessage());
                }
            }

            // WhatsApp Notification
            $this->sendWhatsAppNotification($pengajuanSurat, 'updated');
        }
    }

    protected function sendWhatsAppNotification(PengajuanSurat $pengajuanSurat, string $event)
    {
        $user = $pengajuanSurat->user;
        if (!$user) return;

        $to = $user->telepon;

        if (!$to) {
            Log::info("WhatsApp skip: User {$user->name} has no phone number.");
            return;
        }

        $config = IdentitasDesa::first();
        if (!$config) return;

        $penduduk = $user->penduduk; 

        if ($event === 'created') {
            $template = $config->wa_template_pengajuan;
            if (!$template) return;

            $message = WhatsAppService::parseTemplate($template, [
                'nama' => $penduduk?->nama_lengkap ?? $user->name,
                'jenis_surat' => $pengajuanSurat->jenisSurat?->nama ?? 'Surat',
                'tanggal' => $pengajuanSurat->created_at->format('d/m/Y H:i'),
                'status' => $pengajuanSurat->status,
                'url' => url('/warga/pengajuan-surat/' . $pengajuanSurat->id) // Adjust as needed
            ]);
        } else {
            $template = $config->wa_template_update_status;
            if (!$template) return;

            $message = WhatsAppService::parseTemplate($template, [
                'nama' => $penduduk?->nama_lengkap ?? $user->name,
                'jenis_surat' => $pengajuanSurat->jenisSurat?->nama ?? 'Surat',
                'status_baru' => ucfirst($pengajuanSurat->status),
                'catatan' => $pengajuanSurat->catatan_admin ?? '-',
                'url' => url('/warga/pengajuan-surat/' . $pengajuanSurat->id)
            ]);
        }

        WhatsAppService::send($to, $message);
    }
}
