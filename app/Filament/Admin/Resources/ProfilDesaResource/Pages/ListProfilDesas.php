<?php

namespace App\Filament\Admin\Resources\ProfilDesaResource\Pages;

use App\Filament\Admin\Resources\ProfilDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilDesas extends ListRecords
{
    protected static string $resource = ProfilDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
