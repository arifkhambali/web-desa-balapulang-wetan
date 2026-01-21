<?php

namespace App\Filament\Admin\Resources\AparaturDesaResource\Pages;

use App\Filament\Admin\Resources\AparaturDesaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAparaturDesa extends CreateRecord
{
    protected static string $resource = AparaturDesaResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
