<?php

namespace App\Filament\Exports;

use App\Models\Internship;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class InternshipExporter extends Exporter
{
    protected static ?string $model = Internship::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('student.name'),
            ExportColumn::make('teacher.name'),
            ExportColumn::make('industry.name'),
            ExportColumn::make('start_date'),
            ExportColumn::make('end_date'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your internship export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
