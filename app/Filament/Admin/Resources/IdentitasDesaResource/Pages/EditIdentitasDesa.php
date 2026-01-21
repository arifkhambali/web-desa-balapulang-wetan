<?php

namespace App\Filament\Admin\Resources\IdentitasDesaResource\Pages;

use App\Filament\Admin\Resources\IdentitasDesaResource;
use Filament\Resources\Pages\EditRecord;

class EditIdentitasDesa extends EditRecord
{
    protected static string $resource = IdentitasDesaResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
