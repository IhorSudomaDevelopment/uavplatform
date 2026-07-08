<?php

namespace App\Filament\Resources\Drones\Schemas;

use App\Models\Position;
use App\ValuesObject\DroneStatus;
use App\ValuesObject\DroneType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
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
                Select::make('position_id')
                    ->label('Позиція')
                    ->placeholder('Вибрати')
                    ->options(Position::all()->pluck('title', 'id')->toArray())
                    ->required()
                    ->visible(fn(Get $get) => isRoleAdmin() || isRoleManager()),
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
                    ->placeholder('Вибрати')
                    ->options(DroneType::getList())
                    ->required(),
                Select::make('status')
                    ->label('Статус')
                    ->placeholder('Вибрати')
                    ->options(DroneStatus::getList()),
            ]);
    }
}
