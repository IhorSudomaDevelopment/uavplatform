<?php

namespace App\Filament\Resources\Positions\Schemas;

use App\ValuesObject\PositionStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 *
 */
class PositionForm
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
                Select::make('status')
                    ->options(PositionStatus::getList())
            ]);
    }
}
