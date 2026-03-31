<?php

namespace App\Filament\Resources\Shifts\Tables;

use DB;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShiftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('navigator')
                    ->label('Штурман')
                    ->getStateUsing(function ($record) {
                        return DB::table('users')
                            ->where('id', $record->navigator_id)
                            ->value('assigned_navigator');
                    }),
                TextColumn::make('start_date')
                    ->label('Початок'),
                TextColumn::make('status')
                    ->label('Статус')
                    ->getStateUsing(function ($record) {
                        return $record->end_date === null ? 'Активна' : 'Завершена';
                    })
            ])->recordUrl(NULL)
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
            ])->emptyStateHeading('Записів не знайдено');
    }
}
