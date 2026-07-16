<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\Leftover;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $from = '2026-07-01';
        $to = '2026-07-31';
        $query = Flight::query()
            ->whereBetween('date', [$from, $to]);
        $flights = $query->get();

        $allPositions = $flights->pluck('position', 'id');
        $positions = array_unique($allPositions->toArray());
        print_r($positions);

//        $positionId = 4;
//        $items = [['title' => 'ОГ-Б1', 'quantity' => 2], ['title' => 'МОА-900', 'quantity' => 1]];
//        $leftovers = Leftover::where('position_id', $positionId)->get();
//        foreach ($leftovers as $leftover) {
//           // echo $leftover->title . ' - ' . $leftover->quantity . PHP_EOL;
//            foreach ($items as $item) {
//                if ($leftover->title === $item['title']) {
//                    $leftover->quantity -= $item['quantity'];
//                    $leftover->save();
//                }
//            }
//        }

//        $stats['droneLost'] = 0;
//        $stats['personnel200'] = 0;
//        $stats['personnel300'] = 0;
//        $stats['coverDestroyed'] = 0;
//        $stats['coverAffected'] = 0;
//        $stats['mined'] = 0;
//        $stats['minedPoints'] = 0;
//        $stats['delivery'] = 0;
//        $stats['uavDestroyed'] = 0;
//
//
//        $statsToyota['droneLost'] = 0;
//        $statsToyota['personnel200'] = 0;
//        $statsToyota['personnel300'] = 0;
//        $statsToyota['coverDestroyed'] = 0;
//        $statsToyota['coverAffected'] = 0;
//        $statsToyota['mined'] = 0;
//        $statsToyota['minedPoints'] = 0;
//        $statsToyota['delivery'] = 0;
//        $statsToyota['uavDestroyed'] = 0;
//
//
//        $flights = Flight::where('date', '>=', '2026-07-01')->where('date', '<=', '2026-07-31')->get();
//        foreach ($flights as $flight) {
//            if ($flight->is_drone_lost === 1) {
//                $stats['droneLost']++;
//            }
//            $stats['personnel200'] += $flight->personnel_200;
//            if ($flight->position === 'Тойота') {
//                $statsToyota['personnel200'] += $flight->personnel_200;
//            }
//            $stats['personnel300'] += $flight->personnel_300;
//            if ($flight->position === 'Тойота') {
//                $statsToyota['personnel300'] += $flight->personnel_300;
//            }
//            if ($flight->target === Target::SHELTER) {
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::DESTROYED)) {
//                        $stats['coverDestroyed']++;
//                        if ($flight->position === 'Тойота') {
//                            $statsToyota['coverDestroyed']++;
//                        }
//                    }
//                    if (str_contains($statusData, TargetStatus::AFFECTED)) {
//                        $stats['coverAffected']++;
//                        if ($flight->position === 'Тойота') {
//                            $statsToyota['coverAffected']++;
//                        }
//                    }
//                }
//            } else if ($flight->target === Target::MINING) {
//                $isMined = false;
//                $forPointsQuantity = 0;
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::MINED)) {
//                        $isMined = true;
//                        $stats['mined']++;
//                        if ($flight->position === 'Тойота') {
//                            $statsToyota['mined']++;
//                        }
//                        $forPointsQuantity++;
//                    }
//                }
//                if ($isMined) {
//                    $getFromAmmunition = false;
//                    if (count($flight->getAmmunition()) === 1) {
//                        $getFromAmmunition = true;
//                    }
//                    $pointsFromAmmo = false;
//                    foreach ($flight->getAmmunition() as $ammunitionData) {
//                        if (in_array($ammunitionData['title'], ['ПТМ', 'ІБМ3', 'ІБП', 'ІБМ-1', 'ІБП-1', 'ІБМ-3'], true)) {
//                            if ($getFromAmmunition) {
//                                while ($forPointsQuantity > 0) {
//                                    $stats['minedPoints']++;
//                                    if ($flight->position === 'Тойота') {
//                                        $statsToyota['minedPoints']++;
//                                    }
//                                    $forPointsQuantity--;
//                                }
//                            } else {
//                                $pointsFromAmmo = true;
//                            }
//                        }
//                    }
//                    if ($pointsFromAmmo) {
//                        $stats['minedPoints'] += $forPointsQuantity;
//                        if ($flight->position === 'Тойота') {
//                            $statsToyota['minedPoints'] += $forPointsQuantity;
//                        }
//                    }
//                }
//            } else if ($flight->target === Target::DELIVERY) {
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::DELIVERED)) {
//                        $stats['delivery']++;
//                        if ($flight->position === 'Тойота') {
//                            $statsToyota['delivery']++;
//                        }
//                    }
//                }
//            } else if ($flight->target === Target::UAV) {
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::DESTROYED)) {
//                        $stats['uavDestroyed']++;
//                    }
//                }
//            }
//        }
//        $toyotaPoints = ($statsToyota['personnel200'] * 12) + ($statsToyota['personnel300'] * 8) +
//            ($statsToyota['coverDestroyed'] * 2) + ($statsToyota['coverAffected']) + $statsToyota['minedPoints'];
//        echo '200:' . $statsToyota['personnel200'] . PHP_EOL;
//        echo '300:' . $statsToyota['personnel300'] . PHP_EOL;
//        echo 'Укриття знищено: ' . $statsToyota['coverDestroyed'] . PHP_EOL;
//        echo 'Укриття уражено: ' . $statsToyota['coverAffected'] . PHP_EOL;
//        echo 'Мінувань: ' . $statsToyota['mined'] . PHP_EOL;
//        echo 'Мінувань на бали: ' . $statsToyota['minedPoints'] . PHP_EOL;
//        echo 'БпЛА: ' . $statsToyota['uavDestroyed'] . PHP_EOL;
//        echo 'Доставок: ' . $statsToyota['delivery'] . PHP_EOL;
//        echo $toyotaPoints;
    }
}
