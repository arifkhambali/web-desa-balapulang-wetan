<?php

namespace App\Notifications;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusSuratNotification extends Notification implements ShouldQueue
{
    use Queueable; // Trait for queue support

    public $pengajuanSurat;

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanSurat $pengajuanSurat)
    {
        $this->pengajuanSurat = $pengajuanSurat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusLabels = [
            'pending' => 'Menunggu Konfirmasi',
            'diproses' => 'Sedang Diverifikasi Admin',
            'menunggu_persetujuan' => 'Menunggu Tanda Tangan Kades',
            'selesai' => 'Selesai (Siap Diunduh)',
            'ditolak' => 'Pengajuan Ditolak',
        ];

        $badgeClasses = [
            'pending' => 'badge-warning',
            'diproses' => 'badge-info',
            'menunggu_persetujuan' => 'badge-warning',
            'selesai' => 'badge-success',
            'ditolak' => 'badge-danger',
        ];

        $rawStatus = $this->pengajuanSurat->status;
        $statusLabel = $statusLabels[$rawStatus] ?? ucfirst($rawStatus);
        $badgeClass = $badgeClasses[$rawStatus] ?? 'badge-default';
        
        $jenisSurat = $this->pengajuanSurat->jenisSurat->nama_surat ?? 'Surat Keterangan';
        
        // Determine Action
        $actionUrl = null;
        $actionText = null;
        $introLine = "Ada pembaruan status terkini untuk pengajuan surat Anda.";

        if ($rawStatus === 'selesai' && $this->pengajuanSurat->file_surat) {
             $actionUrl = route('surat.download', $this->pengajuanSurat);
             $actionText = 'Unduh Dokumen Surat';
             $introLine = "Surat Anda telah berhasil diterbitkan dan ditandatangani secara elektronik.";
        } else {
             $actionUrl = route('filament.warga.resources.pengajuan-surats.view', $this->pengajuanSurat);
             $actionText = 'Lihat Detail Pengajuan';
        }

        // Get Identity for Logo
        $identitasDesa = \App\Models\IdentitasDesa::first();

        return (new MailMessage)
            ->subject("Update Status: {$statusLabel} - {$jenisSurat}")
            ->view('emails.status_surat', [
                'identitasDesa' => $identitasDesa,
                'nama_pemohon' => $notifiable->name,
                'intro_line' => $introLine,
                'jenis_surat' => $jenisSurat,
                'nomor_surat' => $this->pengajuanSurat->nomor_surat ?? '-',
                'status_label' => $statusLabel,
                'badge_class' => $badgeClass,
                'catatan' => $this->pengajuanSurat->catatan_admin,
                'action_url' => $actionUrl,
                'action_text' => $actionText
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
