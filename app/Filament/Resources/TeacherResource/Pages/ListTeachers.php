<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Imports\TeacherImporter;
use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->hasRole('super_admin')) {
            return [
                Actions\CreateAction::make(),
            ];
        }

        return [];
    }
}
