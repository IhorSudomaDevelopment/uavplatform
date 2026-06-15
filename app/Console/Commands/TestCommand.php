<?php

namespace App\Console\Commands;

use App\Models\Flight;
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
        $stats['mined'] = 0;
        $stats['minedPoints'] = 0;

        $flights = Flight::query()->whereIn('id', [215, 217])->get();

        foreach ($flights as $flight) {
            $isMined = false;
            $forPointsQuantity = 0;
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::MINED)) {
                    $isMined = true;
                    $stats['mined']++;
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
                                $forPointsQuantity--;
                            }
                        } else {
                            $pointsFromAmmo = true;
                        }
                    }
                }
                if ($pointsFromAmmo) {
                    $stats['minedPoints'] += $forPointsQuantity;
                }
            }
        }
        //echo $stats['mined'] . PHP_EOL;
        echo $stats['minedPoints'] . PHP_EOL;
    }
}
