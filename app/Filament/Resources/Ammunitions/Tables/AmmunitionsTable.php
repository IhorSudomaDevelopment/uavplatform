<?php

namespace App\Filament\Resources\Ammunitions\Tables;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 *
 */
class AmmunitionsTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        $actions = [];
        if (isRoleAdmin()) {
            $actions[] = EditAction::make()->label('Ред.');
        }
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Назва'),
                TextColumn::make('description')
                    ->label('Опис'),
                TextColumn::make('weight')
                    ->label('Вага'),
                TextColumn::make('box_weight')
                    ->label('Вага ящика'),
            ])
            ->filters([
            ])
            ->recordActions($actions)
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Записів не знайдено');
    }
}
