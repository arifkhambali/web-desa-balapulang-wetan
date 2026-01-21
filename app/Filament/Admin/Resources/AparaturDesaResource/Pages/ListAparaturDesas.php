<?php

namespace App\Filament\Admin\Resources\AparaturDesaResource\Pages;

use App\Filament\Admin\Resources\AparaturDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAparaturDesas extends ListRecords
{
    protected static string $resource = AparaturDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
