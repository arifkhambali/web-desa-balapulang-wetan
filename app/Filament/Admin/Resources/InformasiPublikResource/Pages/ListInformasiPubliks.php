<?php

namespace App\Filament\Admin\Resources\InformasiPublikResource\Pages;

use App\Filament\Admin\Resources\InformasiPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiPubliks extends ListRecords
{
    protected static string $resource = InformasiPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
