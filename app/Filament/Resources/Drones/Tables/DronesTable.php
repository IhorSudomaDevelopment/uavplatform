<?php

namespace App\Filament\Resources\Drones\Tables;

use App\ValuesObject\DroneStatus;
use App\ValuesObject\DroneType;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 *
 */
class DronesTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        $actions = [
            ViewAction::make()->label('Перегл.')
                ->modalHeading('Борт')
                ->schema([
                    Section::make()
                        ->columns()
                        ->schema([
                            TextInput::make('title')->label('Назва')->copyable(),
                            TextInput::make('serial_number')->label('СН')->copyable(),
                            TextInput::make('starlink_serial_number')->label('СН Starlink')->copyable(),
                            TextInput::make('kit')->label('KIT')->copyable(),
                            TextInput::make('password')->label('Пароль')->password()->revealable()->copyable(),
                            TextInput::make('additional_info')->label('Додаткова інформація')->copyable(),
                            TextInput::make('type')->label('Тип')->copyable(),
                            TextInput::make('status')->label('Статус')->copyable(),
                        ])]),
            EditAction::make()->label('Ред.'),
            DeleteAction::make()->label('Видалити')
                ->modalHeading('Видалити дрон')
                ->modalDescription('Ви впевнені, що хочете видалити цей дрон?')
                ->modalSubmitActionLabel('Видалити')
                ->modalCancelActionLabel('Скасувати')
                ->successNotificationTitle('Дрон успішно видалено')
        ];
        return $table
            ->columns([
                TextColumn::make('title')->label('Назва'),
                TextColumn::make('serial_number')->label('СН')->searchable(),
                TextColumn::make('kit')->label('KIT'),
                TextColumn::make('type')->label('Тип'),
                TextColumn::make('status')->label('Статус'),
            ])->recordUrl(NULL)
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->multiple()
                    ->options(DroneType::getList()),
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
