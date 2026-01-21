<?php

namespace App\Notifications;

use App\Models\PengajuanSurat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\Actions\Action;

class NewSuratSubmitted extends Notification
{
    use Queueable;

    protected PengajuanSurat $pengajuanSurat;

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
        return ['database'];
    }

    /**
     * Get the Filament database notification representation.
     */
    public function toDatabase(object $notifiable): array
    {
        $jenisSurat = $this->pengajuanSurat->jenisSurat->nama_surat ?? 'Surat';
        $pemohon = $this->pengajuanSurat->user->name ?? 'Warga';
        $body = "{$pemohon} mengajukan {$jenisSurat}. Segera proses pengajuan ini.";

        // Return Filament notification format
        return FilamentNotification::make()
            ->title('Pengajuan Surat Baru')
            ->body($body)
            ->icon('heroicon-o-document-text')
            ->iconColor('info')
            ->actions([
                Action::make('view')
                    ->label('Proses Sekarang')
                    ->url(route('filament.admin.resources.pengajuan-surats.edit', $this->pengajuanSurat->id))
                    ->button()
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
