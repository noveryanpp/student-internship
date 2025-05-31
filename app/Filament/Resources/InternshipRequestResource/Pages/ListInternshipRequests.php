<?php

namespace App\Filament\Resources\InternshipRequestResource\Pages;

use App\Filament\Resources\InternshipRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternshipRequests extends ListRecords
{
    protected static string $resource = InternshipRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
