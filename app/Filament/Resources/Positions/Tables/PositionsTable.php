<?php

namespace App\Filament\Resources\Positions\Tables;

use App\Filament\Resources\Positions\PositionResource;
use App\Models\Leftover;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 *
 */
class PositionsTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Назва'),
                TextColumn::make('status')->label('Статус'),
            ])->recordUrl(NULL)
            ->filters([

            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading('Деталі позиції')
                    ->schema([
                        TextInput::make('title')->label('Нзва')->copyable(),
                        TextInput::make('status')->label('Статус')->copyable(),
                    ]),
                EditAction::make(),
//                Action::make('leftovers')
//                    ->label('Залишки')
//                    ->icon('heroicon-o-archive-box')
//                    ->modalHeading(fn($record) => 'Залишки: ' . $record->title)
//                    ->modalSubmitAction(false)
//                    ->modalCancelActionLabel('Закрити')
//                    ->schema([
//                        Repeater::make('leftovers')
//                            ->label('')
//                            ->default(fn($record) => Leftover::query()
//                                ->where('position_id', $record->id)
//                                ->get()
//                                ->map(fn($leftover) => [
//                                    'title' => $leftover->title,
//                                    'quantity' => $leftover->quantity,
//                                    'unit' => $leftover->unit,
//                                    'leftover_on' => $leftover->leftover_on,
//                                ])
//                                ->toArray())
//                            ->schema([
//                                TextInput::make('title')
//                                    ->label('Назва')
//                                    ->disabled(),
//
//                                TextInput::make('quantity')
//                                    ->label('Кількість')
//                                    ->disabled(),
//
//                                TextInput::make('unit')
//                                    ->label('Одиниця')
//                                    ->disabled(),
//
//                                TextInput::make('leftover_on')
//                                    ->label('Дата')
//                                    ->disabled(),
//                            ])
//                            ->columns(4)
//                            ->addable(true)
//                            ->deletable(true)
//                            ->reorderable(false),
//                    ])
                Action::make('leftovers')
                    ->label('Залишки')
                    ->icon('heroicon-o-archive-box')
                    ->modalHeading(fn ($record) => "Залишки: {$record->title}")
                    ->modalWidth('7xl')
                    ->modalSubmitAction(false)
                    ->modalContent(fn ($record) => view(
                        'filament.positions.leftovers-modal',
                        [
                            'position' => $record,
                        ]
                    )),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->emptyStateHeading('Записів не знайдено');
    }
}
