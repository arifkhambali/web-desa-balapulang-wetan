<?php

namespace App\Filament\Admin\Resources\InformasiPublikResource\Pages;

use App\Filament\Admin\Resources\InformasiPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformasiPublik extends EditRecord
{
    protected static string $resource = InformasiPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
