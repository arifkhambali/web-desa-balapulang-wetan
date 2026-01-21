<?php

namespace App\Filament\Admin\Resources\PengajuanSuratResource\Pages;

use App\Filament\Admin\Resources\PengajuanSuratResource;
use App\Notifications\SuratStatusChanged;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanSurat extends EditRecord
{
    protected static string $resource = PengajuanSuratResource::class;

    protected ?string $oldStatus = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Simpan status lama sebelum form diisi
        $this->oldStatus = $data['status'] ?? null;
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Cek apakah status berubah
        if ($this->oldStatus && $this->oldStatus !== $this->record->status) {
            // Kirim notifikasi ke warga pemilik surat
            $this->record->user->notify(
                new SuratStatusChanged($this->record, $this->oldStatus, $this->record->status)
            );

            // Tampilkan success notification untuk admin
            Notification::make()
                ->success()
                ->title('Status Berhasil Diubah')
                ->body("Notifikasi telah dikirim ke {$this->record->user->name}.")
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
