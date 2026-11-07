<?php

namespace App\Filament\Resources\DroneLosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DroneLostsTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('drone_sn')
                    ->label('СН'),
                TextColumn::make('date')
                    ->label('Дата'),
                TextColumn::make('time')
                    ->label('Час'),
                TextColumn::make('lost_coords')
                    ->label('Координати'),
                TextColumn::make('lost_reason')
                    ->label('Причина'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
