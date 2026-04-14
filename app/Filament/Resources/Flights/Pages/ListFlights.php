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
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use JsonException;

/**
 *
 */
class ListFlights extends ListRecords
{
    /**
     * @var string
     */
    protected static string $resource = FlightResource::class;

    /**
     * @var string|null
     */
    protected static ?string $title = 'Польоти';

    /**
     * @return array|string[]
     */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /**
     * @return array|Action[]|ActionGroup[]
     */
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
                                ->content(fn($get) => $this->buildSummary($get)),
                        ]),
                ]),
        ];
    }


    /**
     * @param $get
     * @return View|Factory|string|\Illuminate\View\View
     * @throws JsonException
     */
    private function buildSummary($get): View|Factory|string|\Illuminate\View\View
    {
        $from = $get('date_from');
        $to = $get('date_to');

        if (!$from || !$to) {
            return 'Оберіть дати';
        }

        $query = DB::table('flights')
            ->whereBetween('date', [$from, $to]);

        if (isRoleNavigator()) {
            $query->where('user_id', auth()->id());
        }

        $flights = $query->get();

        $stats = [
            'status200' => 0,
            'status300' => 0,
            'coverHeat' => 0,
            'coverDestroyed' => 0,
            'coverHeatPoints' => 0,
            'uavDestroyed' => 0,
            'mining' => 0,
            'ptm' => 0,
        ];

        foreach ($flights as $flight) {
            $this->processFlight($flight, $stats);
        }

        $points =
            $stats['status200'] * 12 +
            $stats['status300'] * 6 +
            $stats['coverDestroyed'] * 2 +
            $stats['coverHeatPoints'] +
            $stats['uavDestroyed'] * 2 +
            $stats['ptm'];

        return view(
            'filament.resources.flight-resource.pages.summaries',
            [
                'from' => $from,
                'to' => $to,
                'status200' => $stats['status200'],
                'status300' => $stats['status300'],
                'coverHeat' => $stats['coverHeat'],
                'coverDestroyed' => $stats['coverDestroyed'],
                'mining' => $stats['mining'],
                'uavDestroyed' => $stats['uavDestroyed'],
                'points' => $points,
            ]
        );
    }

    /**
     * @param $flight
     * @param array $stats
     * @return void
     * @throws JsonException
     */
    private function processFlight($flight, array &$stats): void
    {
        $status = $flight->status;

        $has200 = str_contains($status, '200');
        $has300 = str_contains($status, '300');
        $isDestroyed = str_contains($status, TargetStatus::DESTROYED);
        $isAffected = str_contains($status, TargetStatus::AFFECTED);

        $isAffectedExtended = $isAffected || in_array($status, [
                TargetStatus::AFFECTED_AFTER_ADJUSTMENT,
                TargetStatus::AFFECTED_BY_SIGNATURES,
                TargetStatus::AFFECTED_BY_COORDS,
            ]);

        $addCasualties = function () use (&$stats, $status, $has200, $has300) {
            $count = (int)substr($status, -7, 1);

            if ($has200) {
                $stats['status200'] += $count;
            }

            if ($has300) {
                $stats['status300'] += $count;
            }
        };

        switch ($flight->target) {
            case Target::PERSONNEL:
                if ($has200 || $has300) {
                    $addCasualties();
                }
                break;

            case Target::SHELTER:
            case Target::SHELTER_WITH_PERSONNEL:

                if ($isDestroyed) {
                    $stats['coverDestroyed']++;
                    if ($has200 || $has300) {
                        $addCasualties();
                    }
                    break;
                }

                if ($isAffectedExtended) {
                    $stats['coverHeat']++;

                    if ($isAffected) {
                        $stats['coverHeatPoints']++;

                        if ($has200 || $has300) {
                            $addCasualties();
                        }
                    }
                }

                break;

            case Target::UAV:
                if ($flight->status === TargetStatus::DESTROYED) {
                    $stats['uavDestroyed']++;
                }
                break;

            case Target::MINING:
                if ($flight->status === TargetStatus::MINED) {
                    $stats['mining']++;

                    $ammunition = json_decode(
                        $flight->ammunition,
                        true,
                        512,
                        JSON_THROW_ON_ERROR
                    );

                    foreach ($ammunition as $item) {
                        if ($item['title'] === 'ПТМ') {
                            $stats['ptm'] += $item['quantity'];
                        }
                    }
                }
                break;
        }
        if (str_contains($status, 'знищено ворожий БпЛА')) {
            $stats['uavDestroyed']++;
        }
    }
}
