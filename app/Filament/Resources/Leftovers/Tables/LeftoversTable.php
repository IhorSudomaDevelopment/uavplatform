<?php

namespace App\Filament\Resources\Leftovers\Tables;

use App\Models\Position;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 *
 */
class LeftoversTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        $isCouldBeShow = false;
        if (isRoleAdmin() || isRoleManager()) {
            $isCouldBeShow = true;
        }
        $bulkActions = [];
        if (auth()->user()->isPremium()) {
            $bulkActions[] = BulkAction::make('report-bulk')
                ->label('Звіт')
                ->icon('heroicon-o-rectangle-stack')
                ->modalHeading('Звіт по залишкам')
                ->modalContent(fn($records) => view(
                    'filament.resources.leftover-resource.pages.report-leftover-daily-new',
                    ['leftovers' => $records]
                ))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Закрити')
                ->button();
        }
        return $table
            ->columns([
                TextColumn::make('position.title')->label('Позиція')
                    ->visible(fn() => $isCouldBeShow),
                TextColumn::make('title')->label('Назвка'),
                TextColumn::make('quantity')->label('Кількість'),
                TextColumn::make('unit')->label('Одиниці'),
            ])->recordUrl(NULL)
            ->filters([
                SelectFilter::make('position_id')
                    ->label('Позиція')
                    ->multiple()
                    ->options(Position::all()->pluck('title', 'id')),
            ])
            ->recordActions([
                ViewAction::make()->label('Перегл.')
                    ->modalHeading('Деталі по залишку')
                    ->schema([
                        TextInput::make('title')->label('Назва')->copyable(),
                        Textarea::make('quantity')->label('Кількість'),
                        TextInput::make('unit')->label('Одиниця')->copyable(),
                    ]),
                EditAction::make()->label('Ред.'),
            ])
            ->toolbarActions($bulkActions)
            ->emptyStateHeading('Записів не знайдено');
    }
}
