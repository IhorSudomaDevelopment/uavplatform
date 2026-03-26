<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
//        $num = DB::table('flights')
//            ->whereDate('date', now('Europe/Kyiv'))
//            ->max('flight_number');
//
//        $num = ($num ?? 0) + 1;
//        echo $num . PHP_EOL;
        $result = [];
        $flights = DB::table('flights')->where('position', '=', 'Тестова')->get();
        $dateCount = count(array_unique(array_column($flights->toArray(), 'date')));
        if ($dateCount > 1) {

        }

//        if (count(array_unique(array_column($flights->toArray(), 'position'))) > 1) {
//            foreach ($flights as $flight) {
//                $result[$flight->position][] = $flight;
//            }
//        }
//        $r = [];
//        foreach ($result as $value) {
//            foreach ($value as $flight) {
//                $r[$flight->position][$flight->date][] = $flight;
//            }
//        }
//        foreach ($r as $key => $data) {
//            echo 'Позиція: ' . $key . PHP_EOL;
//            foreach ($data as $date => $info) {
//                echo '-Дата: ' . $date . PHP_EOL;
//                foreach ($info as $flight) {
//                    echo '--Номер польоту: ' . $flight->flight_number . PHP_EOL;
//                }
//            }
//        }
    }
}
