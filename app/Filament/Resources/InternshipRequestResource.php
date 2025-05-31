<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternshipRequestResource\Pages;
use App\Filament\Resources\InternshipRequestResource\RelationManagers;
use App\Models\InternshipRequest;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternshipRequestResource extends Resource
{
    protected static ?string $model = InternshipRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasRole('super_admin');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        //
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('industry.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'ready' => 'info',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'ready' => 'Ready to collect',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),
                Tables\Filters\SelectFilter::make('student_internship_status')
                    ->label('Student\'s Internship Status')
                    ->options([
                        1 => 'Already accepted',    // Or 'Yes'
                        0 => 'Not accepted yet',  // Or 'No'
                    ])
                    ->default(0)
                    ->query(function ($query, $state) {
                        return $query->whereHas('student', fn ($q) =>
                        $q->where('internship_status', $state)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('ready')
                    ->label('Ready to collect')
                    ->color('success')
                    ->icon('heroicon-m-check-circle')
                    ->visible(fn ($record) => $record->status == 'pending' && $record->student->internship_status == 0)
                    ->action(function ($record) {
                        try {
                            DB::transaction(function () use ($record) {
                                if($record->student->internship_status == 1) {
                                    throw new \Exception('Student already has an internship.');
                                }
                                $record->update(['status' => 'ready']);

                                Notification::make()
                                    ->title('Student has been notified.')
                                    ->success()
                                    ->send();
                            });
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title($e->getMessage())
                                ->danger()
                                ->send();
                        }

                    })
                    ->requiresConfirmation(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternshipRequests::route('/'),
            'create' => Pages\CreateInternshipRequest::route('/create'),
            'edit' => Pages\EditInternshipRequest::route('/{record}/edit'),
        ];
    }
}
