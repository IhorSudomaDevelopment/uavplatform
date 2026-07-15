<?php

namespace App\Filament\Resources\Logs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 *
 */
class LogsTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Користувач')
                    ->searchable(),

                TextColumn::make('model')
                    ->label('Модель')
                    ->badge(),

                TextColumn::make('model_id')
                    ->label('ID'),

                TextColumn::make('action')
                    ->label('Дія')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->options([
                        'created' => 'Створення',
                        'updated' => 'Редагування',
                        'deleted' => 'Видалення',
                    ]),

                SelectFilter::make('model')
                    ->options([
                        'Drone' => 'Дрони',
                        'Flight' => 'Польоти',
                        'Ammunition' => 'Боєприпаси',
                        'Leftover' => 'Залишки',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
