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
        $forPointsQuantity = 0;
        $flight = Flight::find(215);
        $isMined = false;
        $forPointsQuantity = 0;
        foreach ($flight->getStatus() as $statusData) {
            if (str_contains($statusData, TargetStatus::MINED)) {
                $isMined = true;
                $stats['mined']++;
                $stats['minedPoints'] ++;
                $forPointsQuantity++;
            }
        }
        if ($isMined) {
            $getFromAmmunition = false;
            if (count($flight->getAmmunition()) === 1) {
                $getFromAmmunition = true;
            }
            foreach ($flight->getAmmunition() as $ammunitionData) {
                if (in_array($ammunitionData['title'], ['ПТМ', 'ІБМ3', 'ІБП', 'ІБМ-1', 'ІБП-1', 'ІБМ-3'], true)) {
                    if ($getFromAmmunition) {
                        while ($forPointsQuantity > 0) {
                            $stats['minedPoints']++;
                            $forPointsQuantity--;
                        }
                    }
                }
            }
        }
        echo $stats['minedPoints'];
    }
}
