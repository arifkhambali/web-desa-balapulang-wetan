<?php

namespace App\Notifications;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\Actions\Action;

class SuratStatusChanged extends Notification
{
    use Queueable;

    protected PengajuanSurat $pengajuanSurat;
    protected string $oldStatus;
    protected string $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(PengajuanSurat $pengajuanSurat, string $oldStatus, string $newStatus)
    {
        $this->pengajuanSurat = $pengajuanSurat;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the Filament database notification representation.
     */
    public function toDatabase(object $notifiable): array
    {
        $statusLabels = [
            'pending' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'menunggu_persetujuan' => 'Menunggu Persetujuan',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        $statusIcons = [
            'pending' => 'heroicon-o-clock',
            'diproses' => 'heroicon-o-arrow-path',
            'menunggu_persetujuan' => 'heroicon-o-exclamation-circle',
            'selesai' => 'heroicon-o-check-circle',
            'ditolak' => 'heroicon-o-x-circle',
        ];

        $statusColors = [
            'pending' => 'warning',
            'diproses' => 'info',
            'menunggu_persetujuan' => 'warning',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ];

        $jenisSurat = $this->pengajuanSurat->jenisSurat->nama_surat ?? 'Surat';
        $body = "Pengajuan {$jenisSurat} Anda berubah dari {$statusLabels[$this->oldStatus]} menjadi {$statusLabels[$this->newStatus]}.";

        // Return Filament notification format
        return FilamentNotification::make()
            ->title('Status Surat Berubah')
            ->body($body)
            ->icon($statusIcons[$this->newStatus] ?? 'heroicon-o-bell')
            ->iconColor($statusColors[$this->newStatus] ?? 'primary')
            ->actions([
                Action::make('view')
                    ->label('Lihat Detail')
                    ->url(route('filament.warga.resources.pengajuan-surats.view', $this->pengajuanSurat->id))
                    ->button(),
            ])
            ->getDatabaseMessage();
    }
}
