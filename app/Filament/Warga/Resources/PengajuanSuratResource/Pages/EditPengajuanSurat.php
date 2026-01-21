<?php

namespace App\Filament\Warga\Resources\PengajuanSuratResource\Pages;

use App\Filament\Warga\Resources\PengajuanSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPengajuanSurat extends EditRecord
{
    protected static string $resource = PengajuanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('cancel')
                ->label('Batal')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Mulai dengan lampiran yang sudah ada (filter empty values)
        $currentLampiran = array_values(array_filter($this->record->lampiran ?? []));
        
        // Handle penghapusan lampiran yang dipilih
        if (isset($data['lampiran_hapus']) && !empty($data['lampiran_hapus'])) {
            $filesToDelete = $data['lampiran_hapus'];
            
            // Hapus file yang dipilih dari array
            $currentLampiran = array_values(array_diff($currentLampiran, $filesToDelete));
            
            // Hapus file fisik dari storage
            foreach ($filesToDelete as $file) {
                \Storage::disk('public')->delete($file);
            }
        }
        
        // Jika ada lampiran baru, tambahkan ke lampiran existing
        if (isset($data['lampiran_baru']) && !empty($data['lampiran_baru'])) {
            $currentLampiran = array_values(array_merge($currentLampiran, $data['lampiran_baru']));
        }
        
        // Set lampiran final (pastikan tidak ada empty values)
        $data['lampiran'] = array_values(array_filter($currentLampiran));
        
        // Hapus field temporary
        unset($data['lampiran_baru']);
        unset($data['lampiran_hapus']);
        
        // Reset status ke pending saat submit ulang
        $data['status'] = 'pending';
        $data['sumber_pengajuan'] = 'warga'; // Pastikan flag tetap warga
        $data['tanggal_selesai'] = null;
        $data['file_surat'] = null;
        $data['nomor_surat'] = null;
        
        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Pengajuan Berhasil Diperbarui')
            ->body('Surat Anda telah diajukan ulang dan menunggu verifikasi admin.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
