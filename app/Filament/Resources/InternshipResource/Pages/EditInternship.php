<?php

namespace App\Filament\Resources\InternshipResource\Pages;

use App\Filament\Resources\InternshipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInternship extends EditRecord
{
    protected static string $resource = InternshipResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
