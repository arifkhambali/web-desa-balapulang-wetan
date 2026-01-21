<?php

namespace App\Filament\Admin\Resources\KategoriUmkmResource\Pages;

use App\Filament\Admin\Resources\KategoriUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriUmkms extends ListRecords
{
    protected static string $resource = KategoriUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
