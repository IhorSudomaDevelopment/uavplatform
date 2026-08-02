<?php

namespace App\Filament\Resources\Batteries\Tables;

use App\Models\Battery;
use App\ValuesObject\BatteryAmp;
use App\ValuesObject\DroneStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BatteriesTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        $actions = [
            Action::make('flights_quantity_inc')
                ->label('')
                ->icon('heroicon-o-arrow-up-tray')
                ->tooltip('')
                ->action(function (Battery $record): void {
                    $record->increment('flights_quantity');
                }),
            ViewAction::make()->label('Перегл.')
                ->modalHeading('АКБ')
                ->schema([
                    Section::make()
                        ->columns()
                        ->schema([
                            TextInput::make('title')->label('Назва')->copyable(),
                            TextInput::make('capacity')->label('Ємність')->copyable(),
                            TextInput::make('flights_quantity')->label('К-сть вильотів')->copyable(),
                            TextInput::make('additional_info')->label('Додаткова інформація')->copyable(),
                            TextInput::make('status')->label('Статус')->copyable(),
                        ])]),
            EditAction::make()->label('Ред.'),
            DeleteAction::make()->label('Видалити')
                ->modalHeading('Видалити АКБ')
                ->modalDescription('Ви впевнені, що хочете видалити цю пару АКБ?')
                ->modalSubmitActionLabel('Видалити')
                ->modalCancelActionLabel('Скасувати')
                ->successNotificationTitle('АКБ успішно видалено')
        ];
        return $table
            ->columns([
                TextColumn::make('position.title')
                    ->label('Позиція')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Назва'),
                TextColumn::make('capacity')
                    ->label('Ємність'),
                TextColumn::make('flights_quantity')
                    ->label('К-сть вильотів'),
                TextColumn::make('status')
                    ->label('Статус'),
            ])->recordUrl(NULL)
            ->filters([
                SelectFilter::make('capacity')
                    ->label('Ємність')
                    ->multiple()
                    ->options(BatteryAmp::getList()),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->multiple()
                    ->options(DroneStatus::getList()),
            ])
            ->recordActions($actions)
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Записів не знайдено');
    }
}
