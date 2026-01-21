<?php

namespace App\Filament\Admin\Resources\AnggaranDesaResource\Pages;

use App\Filament\Admin\Resources\AnggaranDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnggaranDesas extends ListRecords
{
    protected static string $resource = AnggaranDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
