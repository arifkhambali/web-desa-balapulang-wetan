<?php

namespace App\Filament\Admin\Resources\PengajuanSuratResource\Pages;

use App\Filament\Admin\Resources\PengajuanSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanSurats extends ListRecords
{
    protected static string $resource = PengajuanSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
