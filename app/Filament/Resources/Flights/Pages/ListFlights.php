<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\Models\Flight;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JsonException;

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
                ->modalWidth('3xl')
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
                            TextInput::make('not_verified')
                                ->label('Не подано')
                                ->default(0)
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

        $query = Flight::query()
            ->whereBetween('date', [$from, $to]);

        if (isRoleNavigator()) {
            $query->where('user_id', auth()->id());
        }

        $flights = $query->get();

        $stats = [
            'personnel200' => 0,
            'personnel300' => 0,
            'coverDestroyed' => 0,
            'coverAffected' => 0,
            'zpm' => 0,
            'mined' => 0,
            'minedPoints' => 0,
            'delivery' => 0,
            'uavDestroyed' => 0,

            'droneLost' => 0,
        ];

        $allPositions = $flights->pluck('position', 'id');
        $positions = array_unique($allPositions->toArray());
        $byPositions = [];
        foreach ($positions as $position) {
            $byPositions[$position] = [
                'personnel200' => 0,
                'personnel300' => 0,
                'coverDestroyed' => 0,
                'coverAffected' => 0,
                'zpm' => 0,
                'mined' => 0,
                'minedPoints' => 0,
                'delivery' => 0,
                'uavDestroyed' => 0,

                'droneLost' => 0,
            ];
        }

        foreach ($flights as $flight) {
            $this->processFlight($flight, $stats, $byPositions);
        }

        $points =
            $stats['personnel200'] * 12 +
            $stats['personnel300'] * 8 +
            $stats['coverDestroyed'] * 2 +
            $stats['coverAffected'] +
            $stats['uavDestroyed'] * 6 +
            $stats['zpm'] +
            $stats['minedPoints'];

        $pointsFact = $points - $get('not_verified');

        return view(
            'filament.resources.flight-resource.pages.summaries',
            [
                'from' => $from,
                'to' => $to,
                'personnel200' => $stats['personnel200'],
                'personnel300' => $stats['personnel300'],
                'coverDestroyed' => $stats['coverDestroyed'],
                'coverAffected' => $stats['coverAffected'],
                'zpm' => $stats['zpm'],
                'mined' => $stats['mined'],
                'minedPoints' => $stats['minedPoints'],
                'delivery' => $stats['delivery'],
                'uavDestroyed' => $stats['uavDestroyed'],
                'points' => $points,
                'pointsFact' => $pointsFact,
                'droneLost' => $stats['droneLost'],

                'byPositions' => $byPositions
            ]
        );
    }

    /**
     * @param $flight
     * @param array $stats
     * @param array $byPositions
     * @return void
     */
    private function processFlight($flight, array &$stats, array &$byPositions): void
    {
        if ($flight->is_drone_lost === 1) {
            $stats['droneLost']++;
        }

        $stats['personnel200'] += $flight->personnel_200;
        $byPositions[$flight->position]['personnel200'] += $flight->personnel_200;

        $stats['personnel300'] += $flight->personnel_300;
        $byPositions[$flight->position]['personnel300'] += $flight->personnel_300;

        if ($flight->target === Target::SHELTER) {
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::DESTROYED)) {
                    $stats['coverDestroyed']++;
                    $byPositions[$flight->position]['coverDestroyed']++;
                }
                if (str_contains($statusData, TargetStatus::AFFECTED)) {
                    $stats['coverAffected']++;
                    $byPositions[$flight->position]['coverAffected']++;
                }
            }
        } else if ($flight->target === Target::MINING) {
            $isMined = false;
            $forPointsQuantity = 0;
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::MINED)) {
                    $isMined = true;
                    $stats['mined']++;
                    $byPositions[$flight->position]['mined']++;
                    $forPointsQuantity++;
                }
            }
            if ($isMined) {
                $getFromAmmunition = false;
                if (count($flight->getAmmunition()) === 1) {
                    $getFromAmmunition = true;
                }
                $pointsFromAmmo = false;
                foreach ($flight->getAmmunition() as $ammunitionData) {
                    if (in_array($ammunitionData['title'], ['ПТМ', 'ІБМ3', 'ІБП', 'ІБМ-1', 'ІБП-1', 'ІБМ-3'], true)) {
                        if ($getFromAmmunition) {
                            while ($forPointsQuantity > 0) {
                                $stats['minedPoints']++;
                                $byPositions[$flight->position]['minedPoints']++;
                                $forPointsQuantity--;
                            }
                        } else {
                            $pointsFromAmmo = true;
                        }
                    }
                }
                if ($pointsFromAmmo) {
                    $stats['minedPoints'] += $forPointsQuantity;
                    $byPositions[$flight->position]['minedPoints'] += $forPointsQuantity;
                }
            }
        } else if ($flight->target === Target::DELIVERY) {
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::DELIVERED)) {
                    $stats['delivery']++;
                    $byPositions[$flight->position]['delivery']++;
                }
            }
        } else if ($flight->target === Target::UAV) {
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::DESTROYED)) {
                    $stats['uavDestroyed']++;
                    $byPositions[$flight->position]['uavDestroyed']++;
                }
            }
        } else if ($flight->target === Target::ZPM) {
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::AFFECTED)) {
                    $stats['zpm']++;
                    $byPositions[$flight->position]['zpm']++;
                }
            }
        }
        foreach ($flight->getStatus() as $statusData) {
            if (str_contains($statusData, 'Знищено ворожий БпЛА')) {
                $stats['uavDestroyed']++;
                $byPositions[$flight->position]['uavDestroyed']++;
            }
        }
    }
}
