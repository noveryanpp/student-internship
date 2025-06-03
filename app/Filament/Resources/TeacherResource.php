<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TeacherExporter;
use App\Filament\Imports\TeacherImporter;
use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('nip')->required(),
                Forms\Components\Select::make('gender')->required()
                    ->options([
                        'M' => 'Male',
                        'F' => 'Female',
                    ]),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->prefix('+62'),
                Forms\Components\TextInput::make('email')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(function($state) {
                        return $state === 'M' ? 'Male' : ($state === 'F' ? 'Female' : $state);
                    }),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(TeacherImporter::class)
                    ->visible(fn () => auth()->user()?->hasRole('super_admin')),
                Tables\Actions\ExportAction::make()
                    ->exporter(TeacherExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records, $action) {
                            $blocked = $records->filter(function ($record) {
                                return $record->internships()->count() > 0;
                            });

                            if ($blocked->isNotEmpty()) {
                                Notification::make()
                                    ->title('Some teachers cannot be deleted')
                                    ->body('Teachers: ' . $blocked->pluck('name')->implode(', ') . ' have related data.')
                                    ->danger()
                                    ->send();

                                $deletable = $records->diff($blocked);

                                if ($deletable->isEmpty()) {
                                    $action->cancel();
                                } else {
                                    $action->records($deletable);
                                }
                            }
                        }),
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(TeacherExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ]),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
