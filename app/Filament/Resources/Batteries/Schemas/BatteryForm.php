<?php

namespace App\Filament\Resources\Batteries\Schemas;

use App\Models\Position;
use App\ValuesObject\BatteryAmp;
use App\ValuesObject\DroneStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class BatteryForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('position_id')
                    ->label('Позиція')
                    ->placeholder('Вибрати')
                    ->options(Position::all()->pluck('title', 'id')->toArray())
                    ->required()
                    ->visible(fn(Get $get) => isRoleAdmin() || isRoleManager()),
                TextInput::make('title')
                    ->label('Назва'),
                TextInput::make('additional_info')
                    ->label('Додатова інформація'),
                Select::make('capacity')
                    ->label('Ємність')
                    ->placeholder('Вибрати')
                    ->options(BatteryAmp::getList()),
                TextInput::make('flights_quantity')
                    ->label('Кількість вильотів')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Select::make('status')
                    ->label('Статус')
                    ->placeholder('Вибрати')
                    ->options(DroneStatus::getList()),
            ]);
    }
}
