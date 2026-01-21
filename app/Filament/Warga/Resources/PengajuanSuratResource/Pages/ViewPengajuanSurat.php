<?php

namespace App\Filament\Warga\Resources\PengajuanSuratResource\Pages;

use App\Filament\Warga\Resources\PengajuanSuratResource;
use Filament\Resources\Pages\ViewRecord;

use Filament\Actions;
use App\Models\PengajuanSurat;

class ViewPengajuanSurat extends ViewRecord
{
    protected static string $resource = PengajuanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download_surat')
                ->label('Download Surat')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn (PengajuanSurat $record) => $record->file_surat ? asset('storage/' . $record->file_surat) : null)
                ->openUrlInNewTab()
                ->visible(fn (PengajuanSurat $record) => $record->status === 'selesai' && $record->file_surat),
        ];
    }
}
