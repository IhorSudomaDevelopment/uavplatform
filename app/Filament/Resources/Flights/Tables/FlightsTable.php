<?php

namespace App\Filament\Resources\Flights\Tables;

use App\Models\Position;
use App\Services\MGRSService;
use App\ValuesObject\Target;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
                    Textarea::make('coordinates')->label('Координати (MGRS)'),
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
                ->modalContent(fn($records) => view(
                    'filament.resources.flight-resource.pages.report-flight-daily-new',
                    ['flights' => $records]
                ))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Закрити')
                ->button();
            $bulkActions[] = BulkAction::make('export')
                ->label('Експорт')
                ->icon('heroicon-o-arrow-down-tray')
                ->schema([
                    CheckboxList::make('fields')
                        ->label('Поля для експорту')
                        ->options([
                            'position' => 'Позиція',
                            'date' => 'Дата',
                            'flight_number' => 'Номер польоту',
                            'time_start' => 'Зліт',
                            'time_end' => 'Посадка',
                            'target' => 'Ціль',
                            'status' => 'Статус',
                            'coordinates' => 'Координати',
                            'personnel_200' => '200',
                            'personnel_300' => '300',
                        ])
                        ->columns(3)
                        ->required(),
                ])
                ->action(function ($records, array $data): BinaryFileResponse {
                    $fields = $data['fields'];
                    $exportData = [];
                    foreach ($records as $record) {
                        $row = [];
                        foreach ($fields as $field) {
                            $value = $record->{$field};
                            if (is_array($value)) {
                                $value = implode(', ', $value);
                            }
                            $row[$field] = $value;
                        }
                        $exportData[] = $row;
                    }
                    $spreadsheet = new Spreadsheet();
                    $activeWorksheet = $spreadsheet->getActiveSheet();
                    $activeWorksheet->fromArray(
                        [self::labelExportFields(array_keys($exportData[0] ?? []))]
                    );
                    $lastColumn = $activeWorksheet
                        ->getHighestColumn();
                    $activeWorksheet
                        ->getStyle('A1:' . $lastColumn . '1')
                        ->getFont()
                        ->setBold(true);
                    foreach (range('A', $lastColumn) as $column) {
                        $activeWorksheet
                            ->getColumnDimension($column)
                            ->setAutoSize(true);
                    }
                    $activeWorksheet->fromArray(
                        $exportData,
                        null,
                        'A2'
                    );
                    $fileName = 'flights-report-' . now()->format('Y-m-d-H-i-s') . '.xlsx';
                    $tempFile = storage_path('app/' . $fileName);
                    $writer = new Xlsx($spreadsheet);
                    $writer->save($tempFile);
                    return response()
                        ->download($tempFile, $fileName)
                        ->deleteFileAfterSend();
                })
                ->modalHeading('Експорт польотів')
                ->modalSubmitActionLabel('Експортувати')
                ->modalCancelActionLabel('Скасувати')
                ->deselectRecordsAfterCompletion()
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
                TextColumn::make('target')
                    ->label('Ціль'),
//                TextColumn::make('coordinates')
//                    ->action(
//                        Action::make('showMap')
//                            ->modalContent(function ($record) {
//                                return view('filament.modals.google-map', [
//                                    'lat' => 0,
//                                    'lng' => 0,
//                                ]);
//                            })
//                    ),
                TextColumn::make('status')
                    ->label('Статус')
                    ->limit(10),
            ])->recordUrl(NULL)
            ->filters([
                SelectFilter::make('target')
                    ->label('Ціль')
                    ->multiple()
                    ->options(Target::getList()),
                SelectFilter::make('result_status')
                    ->label('Статус')
                    ->options([
                        'destroyed' => 'Знищено',
                        'hit' => 'Уражено',
                        'not_hit' => 'Не уражено',
                    ])
                    ->query(function (Builder $query, array $data): Builder {

                        return match ($data['value'] ?? null) {

                            // Є "Уражено", але немає "Не Уражено"
                            'destroed' => $query
                                ->where('status', 'like', '%Знищено%'),

                            // Є "Уражено", але немає "Не Уражено"
                            'hit' => $query
                                ->where('status', 'like', '%Уражено%'),

                            // Є "Не Уражено"
                            'not_hit' => $query
                                ->where('status', 'like', '%Не Уражено%'),

                            default => $query,
                        };
                    }),
                SelectFilter::make('position')
                    ->label('Позиція')
                    ->multiple()
                    ->options(Position::all()->pluck('title', 'title')->toArray()),
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


    /**
     * @param array $fields
     * @return array
     */
    public static function labelExportFields(array $fields): array
    {
        $labels = [];
        foreach ($fields as $field) {
            if ($field === 'position') {
                $labels[] = 'Позиція';
            } else if ($field === 'date') {
                $labels[] = 'Дата';
            } else if ($field === 'flight_number') {
                $labels[] = 'Номер';
            } else if ($field === 'time_start') {
                $labels[] = 'Зліт';
            } else if ($field === 'time_end') {
                $labels[] = 'Посадка';
            } else if ($field === 'target') {
                $labels[] = 'Ціль';
            } else if ($field === 'status') {
                $labels[] = 'Статус';
            } else if ($field === 'coordinates') {
                $labels[] = 'Координати';
            } else if ($field === 'personnel_200') {
                $labels[] = '200';
            } else if ($field === 'personnel_300') {
                $labels[] = '300';
            }
        }
        return $labels;
    }
}
