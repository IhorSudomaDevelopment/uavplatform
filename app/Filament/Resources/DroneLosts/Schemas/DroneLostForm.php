<?php

namespace App\Filament\Resources\DroneLosts\Schemas;

use App\Models\Drone;
use App\ValuesObject\DroneLostReason;
use App\ValuesObject\DroneStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DroneLostForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('drone_lost_sn_with_id')
                    ->label('Дрон (СН)')
                    ->placeholder('Виберіть дрон')
                    ->options(
                        Drone::where('status', DroneStatus::WORK)->pluck('serial_number', 'id')
                    ),
                TextInput::make('time')
                    ->label('Час втрати'),
                DatePicker::make('date')
                    ->label('Дата')
                    ->native(false)
                    ->maxDate(now('Europe/Kyiv'))
                    ->displayFormat('d.m.Y')
                    ->format('Y-m-d')
                    ->default(now('Europe/Kyiv')->format('Y-m-d'))
                    ->required(),
                TextInput::make('lost_coords')
                    ->label('Координати втрати'),
                Select::make('lost_reason')
                    ->label('Причина втрати')
                    ->options(DroneLostReason::getList())
            ]);
    }
}
