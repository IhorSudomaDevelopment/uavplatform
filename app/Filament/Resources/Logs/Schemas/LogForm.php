<?php

namespace App\Filament\Resources\Logs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

/**
 *
 */
class LogForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('model')
                    ->required(),
                TextInput::make('model_id')
                    ->numeric(),
                TextInput::make('action')
                    ->required(),
                TextInput::make('old_values'),
                TextInput::make('new_values'),
                TextInput::make('ip'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
            ]);
    }
}
