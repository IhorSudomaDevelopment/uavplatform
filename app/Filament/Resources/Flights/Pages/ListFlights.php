<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class ListFlights extends ListRecords
{
    /*** @var string */
    protected static string $resource = FlightResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Польоти';

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Додати')
                ->icon('heroicon-o-plus')
                ->visible(fn() => static::getResource()::canCreate()),
            Action::make('summaries')
                ->label('Підсумки')
                ->icon('heroicon-o-chart-bar-square')
                ->modalWidth('xl')
                ->steps([
                    Step::make('Вибір дат')
                        ->schema([
                            DatePicker::make('date_from')
                                ->label('Дата від')
                                ->default(now('Europe/Kyiv')->startOfMonth()->format('Y-m-d'))
                                ->required(),
                            DatePicker::make('date_to')
                                ->label('Дата до')
                                ->default(now('Europe/Kyiv')->format('Y-m-d'))
                                ->required(),
                        ]),
                    Step::make('Результати')
                        ->schema([
                            Placeholder::make('results')
                                ->hiddenLabel()
                                ->content(function ($get) {
                                    $from = $get('date_from');
                                    $to = $get('date_to');
                                    if (!$from || !$to) {
                                        return 'Оберіть дати';
                                    }
                                    $query = DB::table('flights')
                                        ->where('date', '>=', $from)
                                        ->where('date', '<=', $to);
                                    if (isRoleNavigator()) {
                                        $query->where('user_id', auth()->id());
                                    }
                                    $flights = $query->get();
                                    $status200 = 0;
                                    $status300 = 0;
                                    $coverHeat = 0;
                                    $coverDestroyed = 0;
                                    $uavDestroyed = 0;
                                    foreach ($flights as $flight) {
                                        if ($flight->target === Target::PERSONNEL && (str_contains($flight->status, '200') || str_contains($flight->status, '300'))) {
                                            if (str_contains($flight->status, '200')) {
                                                $q200 = substr($flight->status, -7, 1);
                                                $status200 += (int)$q200;
                                            }
                                            if (str_contains($flight->status, '300')) {
                                                $q300 = substr($flight->status, -7, 1);
                                                $status300 += (int)$q300;
                                            }
                                        } else if ($flight->target === Target::SHELTER) {
                                            if ($flight->status === TargetStatus::DESTROYED) {
                                                $coverDestroyed++;
                                            }
                                            if (in_array(
                                                $flight->status,
                                                [
                                                    TargetStatus::AFFECTED,
                                                    TargetStatus::AFFECTED_AFTER_ADJUSTMENT,
                                                    TargetStatus::AFFECTED_BY_SIGNATURES,
                                                    TargetStatus::AFFECTED_BY_COORDS,
                                                ]
                                            )) {
                                                $coverHeat++;
                                            }
                                        } else if ($flight->target === Target::UAV && $flight->status === TargetStatus::DESTROYED) {
                                            $uavDestroyed++;
                                        }
                                    }
                                    return view(
                                        'filament.resources.flight-resource.pages.summaries',
                                        compact(
                                            'from',
                                            'to',
                                            'status200',
                                            'status300',
                                            'coverHeat',
                                            'coverDestroyed',
                                            'uavDestroyed'
                                        )
                                    );
                                }),
                        ]),
                ])
//                ->action(function (array $data) {
//                    // додатково можна обробити після Finish
//                })
        ];
    }
}
