<?php

namespace App\Filament\Admin\Resources\UmkmResource\Pages;

use App\Filament\Admin\Resources\UmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUmkm extends EditRecord
{
    protected static string $resource = UmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika ada gambar baru, ganti gambar lama
        if (isset($data['gambar_baru']) && !empty($data['gambar_baru'])) {
            // Hapus gambar lama dari storage jika ada
            if ($this->record->gambar) {
                \Storage::disk('public')->delete($this->record->gambar);
            }
            $data['gambar'] = $data['gambar_baru'];
        }
        
        // Hapus field temporary
        unset($data['gambar_baru']);
        
        return $data;
    }
}
