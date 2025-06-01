<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

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
                            ->title('Cannot Delete : This Student has internships data')
                            ->danger()
                            ->send();
                        $action->cancel();
                    }
                    if ($record->internship_requests()->count() > 0) {
                        Notification::make()
                            ->title('Cannot Delete : This Student has internship requests data')
                            ->danger()
                            ->send();
                        $action->cancel();
                    }
                    if (User::where('email', $record->email)->count() > 0) {
                        Notification::make()
                            ->title('Cannot Delete : This Student already created an account')
                            ->danger()
                            ->send();
                        $action->cancel();
                    }
                }),
        ];
    }
}
