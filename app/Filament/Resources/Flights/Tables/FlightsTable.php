<?php

namespace App\Filament\Resources\Flights\Tables;

use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class FlightsTable
{
    /**
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        $actions = [
            ViewAction::make()
                ->modalHeading('Деталі польоту')
                ->schema([
                    TextInput::make('flight_number')->label('Номер польоту')->copyable(),
                    TextInput::make('coordinates')->label('Координати (MGRS)')->copyable(),
                    TextInput::make('status')->label('Статус')->copyable(),
                ]),
        ];
        $bulkActions = [];
        if (auth()->user()->isPremium()) {
            $actions[] = Action::make('report')
                ->label('Звіт')
                ->icon('heroicon-o-rectangle-stack')
                ->modalHeading('Звіт за виліт')
                ->modalContent(fn($record): View => view(
                    'filament.resources.flight-resource.pages.report-flight',
                    ['record' => $record]
                ))
                ->modalSubmitAction(FALSE)
                ->modalCancelAction(FALSE);
        }

        if (isRoleAdmin()) {
            $actions[] = EditAction::make();
        }
        if (auth()->user()->isPremium()) {
            $bulkActions[] = BulkAction::make('report-bulk')
                ->label('Звіт')
                ->icon('heroicon-o-rectangle-stack')
                ->modalHeading('Звіт за вибрані польоти')
                ->modalContent(fn ($records) => view(
                    'filament.resources.flight-resource.pages.report-flight-daily-new',
                    ['flights' => $records]
                ))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Закрити')
                ->button();
        }
        return $table
            ->columns([
                TextColumn::make('position')
                    ->label('Позиція'),
                TextColumn::make('date')
                    ->label('Дата'),
                TextColumn::make('flight_number')
                    ->label('Номер'),
                TextColumn::make('time_start')
                    ->label('Зліт'),
                TextColumn::make('time_end')
                    ->label('Посадка'),
                TextColumn::make('target')
                    ->label('Ціль'),
                TextColumn::make('coordinates')
                    ->label('Координати'),
                TextColumn::make('status')
                    ->label('Статус'),
            ])->recordUrl(NULL)
            ->filters([
                SelectFilter::make('target')
                    ->label('Ціль')
                    ->multiple()
                    ->options(Target::getList()),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->multiple()
                    ->options(TargetStatus::getList()),
                Filter::make('by_date')
                    ->default([
                        'date' => now('Europe/Kyiv')->toDateString(),
                    ])
                    ->schema([
                        DatePicker::make('date')
                            ->native(FALSE)
                            //->default(now('Europe/Kyiv')->toDateString())
                            ->displayFormat('Y-m-d')
                            ->label('Дата'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['date'],
                            fn(Builder $query, $date) => $query->whereDate('date', $date)
                        );
                    })->indicateUsing(function (array $data) {
                        if (!$data['date']) {
                            return NULL;
                        }
                        return 'Дата: ' . Carbon::parse($data['date'])->format('Y-m-d');
                    }),
            ])
            ->recordActions($actions)
            ->toolbarActions($bulkActions)
            ->emptyStateHeading('Записів не знайдено');
    }
}
