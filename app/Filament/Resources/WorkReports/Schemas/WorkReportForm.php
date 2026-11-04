<?php

namespace App\Filament\Resources\WorkReports\Schemas;

use App\Models\Position;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WorkReportForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('date')
                    ->label('Дата')
                    ->default(now('Europe/Kyiv')->format('Y-m-d') . ' - ' . now('Europe/Kyiv')->addDay()->format('Y-m-d'))
                    ->required(),
                Select::make('position')
                    ->label('Позиція')
                    ->placeholder('Вибрати')
                    ->options(Position::all()->pluck('title', 'title'))
                    ->required(),
                TextInput::make('crew')
                    ->label('Екіпаж')
                    ->required(),
            ]);
    }
}
