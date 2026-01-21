<?php

namespace App\Filament\Admin\Resources\AnggaranDesaResource\Pages;

use App\Filament\Admin\Resources\AnggaranDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnggaranDesa extends EditRecord
{
    protected static string $resource = AnggaranDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
