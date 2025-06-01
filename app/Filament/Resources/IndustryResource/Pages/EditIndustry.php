<?php

namespace App\Filament\Resources\IndustryResource\Pages;

use App\Filament\Resources\IndustryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditIndustry extends EditRecord
{
    protected static string $resource = IndustryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function ($record, $action) {
                    if ($record->internships()->count() > 0) {
                        Notification::make()
                            ->title('Cannot Delete : This Industry has internships data')
                            ->danger()
                            ->send();
                        $action->cancel();
                    }
                    if ($record->internship_requests()->count() > 0) {
                        Notification::make()
                            ->title('Cannot Delete : This Industry has internship requests data')
                            ->danger()
                            ->send();
                        $action->cancel();
                    }
                }),
        ];
    }
}
