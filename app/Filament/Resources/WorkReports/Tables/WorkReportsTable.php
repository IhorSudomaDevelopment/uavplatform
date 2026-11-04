<?php

namespace App\Filament\Resources\WorkReports\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

class WorkReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position')
                    ->label('Позиція'),
                TextColumn::make('date')
                    ->label('Дата'),
            ])->recordUrl(NULL)
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->label('Перегл.')
                    ->modalHeading('Деталі')
                    ->schema([
                        TextInput::make('position')->label('Позиція')->copyable(),
                        TextInput::make('date')->label('Дата')->copyable(),
                    ]),
                Action::make('report')
                    ->label('Звіт')
                    ->icon('heroicon-o-rectangle-stack')
                    ->modalHeading('Звіт про роботу')
                    ->modalContent(fn($record): View => view(
                        'filament.resources.work-report-resource.pages.work-report',
                        ['record' => $record]
                    ))
                    ->modalSubmitAction(FALSE)
                    ->modalCancelAction(FALSE),
                EditAction::make()->label('Ред.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Записів не знайдено');
    }
}
