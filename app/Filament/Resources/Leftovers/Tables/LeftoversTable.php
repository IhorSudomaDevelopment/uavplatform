<?php

namespace App\Filament\Resources\Leftovers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeftoversTable
{
    public static function configure(Table $table): Table
    {
        $isCouldBeShow = false;
        if (isRoleAdmin() || isRoleManager()) {
            $isCouldBeShow = true;

        }
        return $table
            ->columns([
                TextColumn::make('position')
                    ->visible(fn () => $isCouldBeShow),
                TextColumn::make('title'),
                TextColumn::make('quantity'),
                TextColumn::make('unit'),
                TextColumn::make('leftover_on'),
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
            ])
            ->emptyStateHeading('Записів не знайдено');
    }
}
