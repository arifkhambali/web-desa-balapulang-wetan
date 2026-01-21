<?php

namespace App\Filament\Admin\Resources\PendudukResource\Pages;

use App\Filament\Admin\Resources\PendudukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenduduk extends EditRecord
{
    protected static string $resource = PendudukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
