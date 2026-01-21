<?php

namespace App\Filament\Admin\Resources\IdentitasDesaResource\Pages;

use App\Filament\Admin\Resources\IdentitasDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\IdentitasDesa;

class ListIdentitasDesas extends ListRecords
{
    protected static string $resource = IdentitasDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => IdentitasDesa::count() === 0),
        ];
    }
}
