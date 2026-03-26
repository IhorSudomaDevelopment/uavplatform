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
            $actions[] = EditAction::make();
        }
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Назва'),
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
