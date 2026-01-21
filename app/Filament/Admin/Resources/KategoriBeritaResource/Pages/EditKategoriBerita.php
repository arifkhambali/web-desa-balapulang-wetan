<?php

namespace App\Filament\Admin\Resources\KategoriBeritaResource\Pages;

use App\Filament\Admin\Resources\KategoriBeritaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriBerita extends EditRecord
{
    protected static string $resource = KategoriBeritaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
