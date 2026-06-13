<?php

namespace App\Filament\Resources\Drones\Schemas;

use App\ValuesObject\DroneStatus;
use App\ValuesObject\DroneType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 *
 */
class DroneForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Назва'),
                TextInput::make('serial_number')
                    ->label('Серійний номер')
                    ->required()
                    ->unique(
                        table: 'drones',
                        column: 'serial_number'
                    )
                    ->validationMessages([
                        'unique' => 'Дрон з таким серійним номером вже існує.',
                    ]),
                TextInput::make('starlink_serial_number')
                    ->label('Серійний номер Starlink'),
                TextInput::make('kit')
                    ->label('KIT'),
                TextInput::make('password')
                    ->label('Пароль'),
                TextInput::make('additional_info')
                    ->label('Додатова інформація'),
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
