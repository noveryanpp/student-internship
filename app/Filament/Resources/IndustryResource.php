<?php

namespace App\Filament\Resources;

use App\Filament\Exports\IndustryExporter;
use App\Filament\Imports\IndustryImporter;
use App\Filament\Resources\IndustryResource\Pages;
use App\Filament\Resources\IndustryResource\RelationManagers;
use App\Models\Industry;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustryResource extends Resource
{
    protected static ?string $model = Industry::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('field')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->prefix('+62'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('website'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('field')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
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
                    ->importer(IndustryImporter::class)
                    ->visible(fn () => auth()->user()?->hasRole('super_admin')),
                Tables\Actions\ExportAction::make()
                    ->exporter(IndustryExporter::class)
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
                                return $record->internships()->count() > 0 || $record->internship_requests()->count() > 0;
                            });

                            if ($blocked->isNotEmpty()) {
                                Notification::make()
                                    ->title('Some industries cannot be deleted')
                                    ->body('Industries: ' . $blocked->pluck('name')->implode(', ') . ' have related data.')
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
                    ->exporter(IndustryExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                ]),
            ]);
    }

//    public static function canDelete($record): bool
//    {
//        return $record->internships->count() === 0 && $record->internship_requests->count() === 0;
//    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndustries::route('/'),
            'create' => Pages\CreateIndustry::route('/create'),
            'edit' => Pages\EditIndustry::route('/{record}/edit'),
        ];
    }
}
