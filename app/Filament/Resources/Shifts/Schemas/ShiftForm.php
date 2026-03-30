<?php

namespace App\Filament\Resources\Shifts\Schemas;

use App\ValuesObject\PositionStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('position_id')
                    ->label('Позиція')
                    //->relationship('position', 'title'),
                    ->options(DB::table('positions')
                        ->where('status', PositionStatus::WORK)
                        ->pluck('title', 'id')),
                Select::make('navigator_id')
                    ->label('Штурман')
                    ->options(DB::table('users')
                        ->where('role', 'navigator')
                        ->pluck('assigned_navigator', 'id')),
                TextInput::make('start_date'),
                TextInput::make('end_date'),
                Checkbox::make('is_night')->label('Нічна'),
            ]);
    }
}
