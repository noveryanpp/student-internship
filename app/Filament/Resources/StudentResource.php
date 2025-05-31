<?php

namespace App\Filament\Resources;

use App\Filament\Exports\StudentExporter;
use App\Filament\Imports\StudentImporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('nis')->required(),
                Forms\Components\Select::make('gender')->required()
                    ->options([
                        'M' => 'Male',
                        'F' => 'Female',
                    ]),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\TextInput::make('email')->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('students')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
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
                Tables\Columns\IconColumn::make('internship_status')
                    ->boolean()
                    ->alignCenter()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(StudentImporter::class),
                Tables\Actions\ExportAction::make()
                    ->exporter(StudentExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(StudentExporter::class)
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
