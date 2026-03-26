<?php

namespace App\Filament\Resources\Drones\Schemas;

use App\ValuesObject\DroneStatus;
use App\ValuesObject\DroneType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DroneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва'),
                TextInput::make('serial_number')
                    ->label('Серійний номер')
                    ->required(),
                TextInput::make('kit')
                    ->label('KIT'),
                TextInput::make('password')
                    ->label('Пароль'),
                Select::make('type')
                    ->label('Тип')
                    ->options(DroneType::getList())
                    ->required(),
                Select::make('status')
                    ->label('Статус')
                    ->options(DroneStatus::getList()),
            ]);
    }
}
