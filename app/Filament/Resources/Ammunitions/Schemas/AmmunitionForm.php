<?php

namespace App\Filament\Resources\Ammunitions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 *
 */
class AmmunitionForm
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
                    ->label('Назва')
                    ->required(),
                TextInput::make('description')
                    ->label('Опис'),
            ]);
    }
}
