<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\Shift;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
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
        $stats = [
            'personnel200' => 0,
            'personnel300' => 0,
            'coverHeat' => 0,
            'coverDestroyed' => 0,
            'coverAffected' => 0,
            'uavDestroyed' => 0,
            'mined' => 0,
            'minedPoints' => 0,
        ];
        $flight = Flight::whereId(62)->first();
        $isMined = false;
        if (in_array($flight->target, [Target::SHELTER, Target::SHELTER_WITH_PERSONNEL], true)) {
            foreach ($flight->getStatus() as $statusData) {
                if (str_contains($statusData, TargetStatus::DESTROYED)) {
                    $stats['coverDestroyed']++;
                }
                if (str_contains($statusData, TargetStatus::AFFECTED)) {
                    $stats['coverAffected']++;
                }
            }
        }
        echo $stats['coverAffected'] . PHP_EOL;

//        $personnel200 = 0;
//        $personnel300 = 0;
//        $coverDestroyed = 0;
//        $coverAffected = 0;
//        $mined = 0;
//        $minedPoints = 0;
//        $uavDestroyed = 0;
//
//        $flights = Flight::all();
//        foreach ($flights as $flight) {
//            $personnel200 += $flight->personnel_200;
//            $personnel300 += $flight->personnel_300;
//            if (in_array($flight->target, [Target::SHELTER, Target::SHELTER_WITH_PERSONNEL], true)) {
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::DESTROYED)) {
//                        $coverDestroyed++;
//                    }
//                    if (str_contains($statusData, TargetStatus::AFFECTED)) {
//                        $coverAffected++;
//                    }
//                }
//            } else if ($flight->target === Target::MINING) {
//                $isMined = false;
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::MINED)) {
//                        $isMined = true;
//                        $mined++;
//                    }
//                }
//                if ($isMined) {
//                    foreach ($flight->getAmmunition() as $ammunitionData) {
//                        if (in_array($ammunitionData['title'], ['ПТМ', 'ІБМ3'], true)) {
//                            $minedPoints++;
//                        }
//                    }
//                }
//            } else if ($flight->target === Target::UAV) {
//                foreach ($flight->getStatus() as $statusData) {
//                    if (str_contains($statusData, TargetStatus::DESTROYED)) {
//                        $uavDestroyed++;
//                    }
//                }
//            }
//        }
//
//        echo '' . $personnel200 . PHP_EOL;
//        echo '' . $personnel300 . PHP_EOL;
//        echo '' . $coverDestroyed . PHP_EOL;
//        echo '' . $coverAffected . PHP_EOL;
//        echo '' . $mined . PHP_EOL;
//        echo '' . $minedPoints . PHP_EOL;
//        echo '' . $uavDestroyed . PHP_EOL;

//        $flight = Flight::where('id', 6)->first();
//        $p['s'] = 1;
//        $count = 0;
//        $positions = [];
//        $offset = 0;
//        while (($pos = strpos($flight->coordinates, '37T', $offset)) !== false) {
//            $positions[] = $pos;
//            $offset = $pos + 1;
//            $count++;
//        }
//        if ($count >= 2) {
//            $p['s'] += $count - 1;
//        }
//        echo $p['s'];

        /* `if0_41390252_uavplatform`.`flights` */
//        $flights = array(
//            array('id' => '1','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '1','date' => '2026-03-25','time_start' => '05:59','time_end' => '06:30','target' => 'Укриття','coordinates' => '37T CN 05701 99558','status' => 'Уражено','ammunition' => '[{"title": "ОГ-Б1", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-03-25 03:40:01','updated_at' => '2026-03-25 03:40:01'),
//            array('id' => '2','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '2','date' => '2026-03-25','time_start' => '09:52','time_end' => '10:11','target' => 'ОС','coordinates' => '37T CN 03329 98129','status' => 'Уражено, 1 - 300','ammunition' => '[{"title": "ОГ-Б1", "quantity": "2"}, {"title": "МОА-400", "quantity": 1}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-03-25 03:45:29','updated_at' => '2026-03-25 03:45:29'),
//            array('id' => '3','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '3','date' => '2026-03-25','time_start' => '14:42','time_end' => '15:05','target' => 'Укриття','coordinates' => '37T CN 01520 99710','status' => 'Знищено','ammunition' => '[{"title": "ТМ-62М", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-03-25 09:09:06','updated_at' => '2026-03-25 09:09:06'),
//            array('id' => '4','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '4','date' => '2026-03-25','time_start' => '16:37','time_end' => '17:19','target' => 'Укриття','coordinates' => '37T CN 03788 99772','status' => 'Не уражено (невлучання)','ammunition' => '[{"title": "ОГ-Б1", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-03-26 04:54:26','updated_at' => '2026-03-26 04:54:26'),
//            array('id' => '5','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '1','date' => '2026-03-26','time_start' => '11:28','time_end' => '12:08','target' => 'ОС','coordinates' => '37T CP 01830 01077','status' => 'Не уражено (подавлення)','ammunition' => '[{"title": "МОА-400", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-03-26 04:55:09','updated_at' => '2026-03-26 04:55:09'),
//            array('id' => '66','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-02','time_start' => '23:49','time_end' => '00:33','target' => 'Укриття','coordinates' => '37T CN 06069 98699','status' => 'Уражено (по тепловим сигнатурах)','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-03 05:19:49','updated_at' => '2026-04-03 05:19:49'),
//            array('id' => '67','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-03','time_start' => '18:40','time_end' => '19:13','target' => 'ОС','coordinates' => '37T CN 03789 99627','status' => 'Знищено, 1 - 200','ammunition' => '[{"title": "ОГ-Б1", "quantity": "3"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-04 04:50:32','updated_at' => '2026-04-04 04:50:32'),
//            array('id' => '69','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-04','time_start' => '00:03','time_end' => '00:38','target' => 'Укриття','coordinates' => '37T CP 06384 00099','status' => 'Уражено (за координатами)','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-04 04:52:40','updated_at' => '2026-04-04 04:52:40'),
//            array('id' => '70','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-04','time_start' => '02:04','time_end' => '02:35','target' => 'Доставка','coordinates' => '37T CP 05358 02503','status' => 'Доставлено','ammunition' => '[{"title": "Посилка", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-04 04:53:19','updated_at' => '2026-04-04 04:53:19'),
//            array('id' => '71','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-04','time_start' => '02:40','time_end' => '03:13','target' => 'Мінування','coordinates' => '37T CN 04152 97625
//37T CN 04175 97625','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-04 04:53:56','updated_at' => '2026-04-04 04:53:56'),
//            array('id' => '72','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-04-04','time_start' => '03:40','time_end' => '04:10','target' => 'Укриття','coordinates' => '37T CP 03676 00475','status' => 'Уражено (за координатами)','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-04 04:55:05','updated_at' => '2026-04-04 04:55:05'),
//            array('id' => '79','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-04','time_start' => '20:35','time_end' => '20:52','target' => 'ОС','coordinates' => '37T CN 00576 94366','status' => 'Не уражено (втрата борта)','ammunition' => '[{"title": "ОГ-Б1", "quantity": "4"}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-04-05 06:43:53','updated_at' => '2026-04-05 06:43:53'),
//            array('id' => '80','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-05','time_start' => '00:15','time_end' => '00:48','target' => 'Мінування','coordinates' => '37T CN 02190 99200
//37T CN 02194 99212','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-05 06:44:20','updated_at' => '2026-04-05 06:44:20'),
//            array('id' => '81','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-05','time_start' => '01:55','time_end' => '02:25','target' => 'Мінування','coordinates' => '37T CN 01733 99553
//37T CN 01731 99550','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-05 06:45:02','updated_at' => '2026-04-05 06:45:02'),
//            array('id' => '82','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-05','time_start' => '02:56','time_end' => '03:32','target' => 'Укриття','coordinates' => '37T CN 00145 96000','status' => 'Уражено','ammunition' => '[{"title": "ФАБ 7", "quantity": 1}, {"title": "ТМ-2025", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-05 06:45:41','updated_at' => '2026-04-05 06:45:41'),
//            array('id' => '83','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-04-05','time_start' => '04:03','time_end' => '04:40','target' => 'Укриття','coordinates' => '37T CN 00145 96000','status' => 'Знищено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ТМ-2025", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-05 06:46:08','updated_at' => '2026-04-05 06:46:08'),
//            array('id' => '87','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-06','time_start' => '00:37','time_end' => '01:05','target' => 'Мінування','coordinates' => '37T CN 01884 99392
//37T CN 01889 99383','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-06 05:02:56','updated_at' => '2026-04-06 05:02:56'),
//            array('id' => '88','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-06','time_start' => '01:27','time_end' => '01:46','target' => 'Хант БПЛА','coordinates' => '-','status' => 'Не виявлено','ammunition' => '[{"title": "ОГ-Б1", "quantity": "3"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-06 05:03:31','updated_at' => '2026-04-06 05:03:31'),
//            array('id' => '94','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-06','time_start' => '23:57','time_end' => '00:36','target' => 'Мінування','coordinates' => '37T CN 04942 98138
//37T CN 04927 98146','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-07 06:48:39','updated_at' => '2026-04-07 06:48:39'),
//            array('id' => '95','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-07','time_start' => '03:43','time_end' => '04:18','target' => 'ОС','coordinates' => '37T CN 05341 99333','status' => 'Знищено, 1 - 200','ammunition' => '[{"title": "ОГ-Б1", "quantity": "3"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-07 06:49:15','updated_at' => '2026-04-07 06:49:15'),
//            array('id' => '99','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-07','time_start' => '19:08','time_end' => '19:17','target' => 'Укриття','coordinates' => '37T CN 08325 98711','status' => 'Не уражено (втрата борта)','ammunition' => '[{"title": "ОГ-Б1", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-04-09 06:52:32','updated_at' => '2026-04-09 06:52:32'),
//            array('id' => '100','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-07','time_start' => '22:40','time_end' => '22:47','target' => 'Перегін борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 06:53:11','updated_at' => '2026-04-09 06:53:11'),
//            array('id' => '101','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-08','time_start' => '00:17','time_end' => '00:48','target' => 'Мінування','coordinates' => '37T CN 04884 98127
//37T CN 04889 98132','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 06:54:03','updated_at' => '2026-04-09 06:54:03'),
//            array('id' => '102','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-08','time_start' => '01:02','time_end' => '01:32','target' => 'Укриття','coordinates' => '37T CN 04837 99210','status' => 'Знищено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 06:54:39','updated_at' => '2026-04-09 06:54:39'),
//            array('id' => '103','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-04-08','time_start' => '02:23','time_end' => '02:53','target' => 'Укриття','coordinates' => '37T CN 05343 99349','status' => 'Знищено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 06:55:13','updated_at' => '2026-04-09 06:55:13'),
//            array('id' => '114','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-08','time_start' => '20:43','time_end' => '20:56','target' => 'Хант БПЛА','coordinates' => '-','status' => 'Не виявлено','ammunition' => '[{"title": "-", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 07:34:16','updated_at' => '2026-04-09 07:34:16'),
//            array('id' => '115','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-08','time_start' => '21:03','time_end' => '21:16','target' => 'БПЛА','coordinates' => '37T CP 03823 09901','status' => 'Не уражено (відсутня ціль)','ammunition' => '[{"title": "-", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 07:34:49','updated_at' => '2026-04-09 07:34:49'),
//            array('id' => '116','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-08','time_start' => '22:44','time_end' => '23:19','target' => 'Мінування','coordinates' => '37T CN 04973 98104
//37T CN 04964 98104','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 07:35:27','updated_at' => '2026-04-09 07:35:27'),
//            array('id' => '117','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-08','time_start' => '23:29','time_end' => '23:59','target' => 'Укриття','coordinates' => '37T CN 05463 98682','status' => 'Уражено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 07:36:02','updated_at' => '2026-04-09 07:36:02'),
//            array('id' => '118','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-04-09','time_start' => '00:42','time_end' => '01:18','target' => 'Мінування','coordinates' => '37T CN 04938 98100
//37T CN 04932 98099','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-09 07:41:15','updated_at' => '2026-04-09 07:41:15'),
//            array('id' => '121','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-09','time_start' => '20:49','time_end' => '21:23','target' => 'Укриття','coordinates' => '37T CN 09104 99374','status' => 'Уражено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "ФАБ 7", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 06:47:59','updated_at' => '2026-04-10 06:47:59'),
//            array('id' => '122','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-09','time_start' => '21:30','time_end' => '21:54','target' => 'Мінування','coordinates' => '37T CN 07833 98033
//37T CN 07828 98035
//37T CN 07822 98046','status' => 'Заміновано','ammunition' => '[{"title": "ПТМ", "quantity": "3"}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-04-10 06:48:25','updated_at' => '2026-04-10 06:48:25'),
//            array('id' => '123','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-09','time_start' => '22:57','time_end' => '23:26','target' => 'Укриття','coordinates' => '37T CN 05463 98962','status' => 'Уражено','ammunition' => '[{"title": "МОА-400", "quantity": 1}, {"title": "МОА-900", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 06:49:39','updated_at' => '2026-04-10 06:49:39'),
//            array('id' => '124','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-09','time_start' => '23:32','time_end' => '23:42','target' => 'Доставка','coordinates' => '-','status' => 'Доставлено','ammunition' => '[{"title": "Посилка", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 06:50:14','updated_at' => '2026-04-10 06:50:14'),
//            array('id' => '125','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-04-10','time_start' => '00:42','time_end' => '01:05','target' => 'Евакуація борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[{"title": "БпЛА Вампір", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 07:25:39','updated_at' => '2026-04-10 07:25:39'),
//            array('id' => '126','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '6','date' => '2026-04-10','time_start' => '02:11','time_end' => '02:42','target' => 'Укриття','coordinates' => '37T CN 02904 99859','status' => 'Уражено','ammunition' => '[{"title": "ОГ-Б1", "quantity": 1}, {"title": "МОА-900", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 07:26:13','updated_at' => '2026-04-10 07:26:13'),
//            array('id' => '127','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '7','date' => '2026-04-10','time_start' => '04:32','time_end' => '05:08','target' => 'Укриття','coordinates' => '37T CN 05547 98178','status' => 'Уражено','ammunition' => '[{"title": "МОА-900", "quantity": 1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-10 07:26:45','updated_at' => '2026-04-10 07:26:45'),
//            array('id' => '134','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-10','time_start' => '19:50','time_end' => '20:23','target' => 'ОС','coordinates' => '37T CN 02515 99820
//37T CN 02654 99840','status' => 'Уражено (по тепловим сигнатурах)','ammunition' => '[{"title":"\\u041e\\u0413-\\u04111","quantity":"4"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-12 06:16:53','updated_at' => '2026-04-12 06:16:53'),
//            array('id' => '135','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-10','time_start' => '23:50','time_end' => '00:25','target' => 'Мінування','coordinates' => '37T CN 09178 98156
//37T CN 09173 98159','status' => 'Заміновано','ammunition' => '[{"title":"\\u041f\\u0422\\u041c","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-12 06:17:37','updated_at' => '2026-04-12 06:17:37'),
//            array('id' => '136','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-11','time_start' => '00:30','time_end' => '00:32','target' => 'Укриття','coordinates' => '37T CN 05547 98178','status' => 'Не уражено (втрата борта)','ammunition' => '[{"title":"\\u041c\\u041e\\u0410-120","quantity":1},{"title":"\\u041c\\u041e\\u0410-900","quantity":1}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-04-12 06:18:40','updated_at' => '2026-04-12 06:18:40'),
//            array('id' => '161','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '3','date' => '2026-03-25','time_start' => '00:11','time_end' => '00:36','target' => 'Доставка','coordinates' => '37T CN 00195 99031','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-14 01:51:20','updated_at' => '2026-05-20 02:48:44'),
//            array('id' => '162','shift_id' => '1','user_id' => '7','position' => 'ХТЗ','flight_number' => '4','date' => '2026-03-25','time_start' => '00:42','time_end' => '01:04','target' => 'Доставка','coordinates' => '37T CN 00195 00499','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-14 01:52:07','updated_at' => '2026-05-20 02:49:10'),
//            array('id' => '179','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-04-14','time_start' => '18:58','time_end' => '19:22','target' => 'Укриття з ОС','coordinates' => '37T BP 99315 02873','status' => 'Знищено','ammunition' => '[{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-14 19:43:39','updated_at' => '2026-04-14 19:43:39'),
//            array('id' => '180','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-04-14','time_start' => '21:07','time_end' => '21:28','target' => 'Перегін борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-14 21:37:53','updated_at' => '2026-04-14 21:37:53'),
//            array('id' => '181','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-04-15','time_start' => '01:10','time_end' => '01:38','target' => 'Мінування','coordinates' => '37T CN 05875 98231
//37T CN 05859 98219','status' => 'Заміновано','ammunition' => '[{"title":"\\u041f\\u0422\\u041c","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-15 01:56:20','updated_at' => '2026-04-15 01:56:20'),
//            array('id' => '182','shift_id' => '6','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-04-15','time_start' => '03:10','time_end' => '03:52','target' => 'Мінування','coordinates' => '37T CN 05861 98204
//37T CN 05859 98209','status' => 'Заміновано','ammunition' => '[{"title":"\\u041f\\u0422\\u041c","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-04-15 04:06:01','updated_at' => '2026-04-15 04:06:01'),
//            array('id' => '217','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-11','time_start' => '21:36','time_end' => '22:05','target' => 'Доставка','coordinates' => '37T CP 06802 02655','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:17:26','updated_at' => '2026-05-15 22:17:26'),
//            array('id' => '218','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-11','time_start' => '23:00','time_end' => '23:43','target' => 'Мінування','coordinates' => '37T CN 07781 98022 (19074)
//37T CN 07712 98001 (19012)','status' => 'Заміновано','ammunition' => '[{"title":"\\u041e\\u0417\\u041c-72","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:19:56','updated_at' => '2026-05-15 22:19:56'),
//            array('id' => '219','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-12','time_start' => '01:54','time_end' => '02:03','target' => 'Доставка','coordinates' => '37T BP 99222 10781','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:20:51','updated_at' => '2026-05-15 22:20:51'),
//            array('id' => '220','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-12','time_start' => '02:48','time_end' => '03:19','target' => 'Доставка','coordinates' => '37T CN 02752 98701','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:22:00','updated_at' => '2026-05-15 22:22:00'),
//            array('id' => '221','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-12','time_start' => '03:25','time_end' => '03:54','target' => 'Доставка','coordinates' => '37Т CP 01420 00054','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:22:46','updated_at' => '2026-05-15 22:22:46'),
//            array('id' => '222','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '6','date' => '2026-05-12','time_start' => '04:53','time_end' => '05:28','target' => 'ОС','coordinates' => '37T CN 02055 98802','status' => 'Знищено, 1 - 200','ammunition' => '[{"title":"\\u041c\\u041e\\u0410-400","quantity":1},{"title":"\\u041c\\u041e\\u0410-900","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:23:48','updated_at' => '2026-05-15 22:23:48'),
//            array('id' => '223','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-12','time_start' => '21:30','time_end' => '21:42','target' => 'ОС','coordinates' => '37T CN 00100 99910','status' => 'Не уражено (втрата борта)','ammunition' => '[{"title":"\\u041c\\u0410\\u0411-\\u041b3","quantity":"3"}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-05-15 22:26:55','updated_at' => '2026-05-15 22:26:55'),
//            array('id' => '224','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-12','time_start' => '23:19','time_end' => '23:49','target' => 'Доставка','coordinates' => '37Т CN 02550 98662','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:27:43','updated_at' => '2026-05-15 22:27:43'),
//            array('id' => '225','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-12','time_start' => '23:56','time_end' => '00:19','target' => 'Доставка','coordinates' => 'позиція Джміль, позиція Тойота','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:29:01','updated_at' => '2026-05-15 22:29:01'),
//            array('id' => '226','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-13','time_start' => '00:36','time_end' => '01:05','target' => 'Доставка','coordinates' => '37T CN 02598 99843','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:29:52','updated_at' => '2026-05-15 22:29:52'),
//            array('id' => '227','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-13','time_start' => '02:54','time_end' => '03:29','target' => 'Мінування','coordinates' => '37T CN 05040 98131 (19301)','status' => 'Заміновано','ammunition' => '[{"title":"\\u041e\\u0417\\u041c-72","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:31:07','updated_at' => '2026-05-15 22:31:07'),
//            array('id' => '228','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '6','date' => '2026-05-13','time_start' => '03:36','time_end' => '04:16','target' => 'Укриття','coordinates' => '37T CN 08284 98691','status' => 'Уражено','ammunition' => '[{"title":"\\u0424\\u0410\\u0411 14","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:31:57','updated_at' => '2026-05-15 22:31:57'),
//            array('id' => '229','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-13','time_start' => '20:06','time_end' => '20:27','target' => 'Перегін борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:33:20','updated_at' => '2026-05-15 22:33:20'),
//            array('id' => '230','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-13','time_start' => '21:43','time_end' => '22:12','target' => 'Доставка','coordinates' => '37Т СN 01673 99557','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:33:59','updated_at' => '2026-05-15 22:33:59'),
//            array('id' => '231','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-13','time_start' => '22:20','time_end' => '22:50','target' => 'Доставка','coordinates' => '37T CN 02748 98716','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 22:35:30','updated_at' => '2026-05-15 22:35:30'),
//            array('id' => '232','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-13','time_start' => '23:07','time_end' => '23:47','target' => 'Укриття','coordinates' => '37T CN 06540 95389
//37T CN 06534 95381','status' => 'Уражено','ammunition' => '[{"title":"\\u041c\\u0410\\u0411-\\u041b3","quantity":1},{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:23:16','updated_at' => '2026-05-15 23:23:16'),
//            array('id' => '233','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-14','time_start' => '02:08','time_end' => '02:45','target' => 'Укриття','coordinates' => '37T CN 00610 99422','status' => 'Знищено','ammunition' => '[{"title":"Penetrator","quantity":1},{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:25:15','updated_at' => '2026-05-15 23:25:15'),
//            array('id' => '234','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-14','time_start' => '22:11','time_end' => '22:44','target' => 'Доставка','coordinates' => '37Т СN 01673 99557','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:26:20','updated_at' => '2026-05-15 23:26:20'),
//            array('id' => '235','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-14','time_start' => '23:00','time_end' => '23:34','target' => 'Доставка','coordinates' => '37Т CP 01420 00054','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:27:31','updated_at' => '2026-05-15 23:27:31'),
//            array('id' => '236','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-15','time_start' => '00:31','time_end' => '01:09','target' => 'Укриття','coordinates' => '37Т CN 00616 99421','status' => 'Знищено','ammunition' => '[{"title":"Penetrator","quantity":1},{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:28:39','updated_at' => '2026-05-15 23:28:39'),
//            array('id' => '237','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-15','time_start' => '01:55','time_end' => '02:34','target' => 'Укриття','coordinates' => '37Т BN 99776 95874','status' => 'Уражено','ammunition' => '[{"title":"\\u0424\\u0410\\u0411 7","quantity":1},{"title":"\\u041c\\u041e\\u0410-400","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:30:06','updated_at' => '2026-05-15 23:30:06'),
//            array('id' => '238','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-15','time_start' => '06:27','time_end' => '06:54','target' => 'ОС','coordinates' => '37T CP 05806 03437','status' => 'Уражено (за координатами)','ammunition' => '[{"title":"\\u041c\\u0410\\u0411-\\u041b3","quantity":"3"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:30:57','updated_at' => '2026-05-15 23:30:57'),
//            array('id' => '239','shift_id' => '8','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-15','time_start' => '23:23','time_end' => '23:58','target' => 'Доставка','coordinates' => '37T CN 02550 98662','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-15 23:40:18','updated_at' => '2026-05-16 00:05:01'),
//            array('id' => '240','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-16','time_start' => '00:46','time_end' => '01:15','target' => 'Доставка','coordinates' => '37T CP 01126 00939','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-16 01:14:26','updated_at' => '2026-05-16 01:14:26'),
//            array('id' => '241','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-16','time_start' => '01:53','time_end' => '02:40','target' => 'Мінування','coordinates' => '37T CN 08951 93349
//37T CN 08956 93345','status' => 'Заміновано','ammunition' => '[{"title":"\\u0406\\u0411\\u041c3","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-16 02:42:04','updated_at' => '2026-05-16 02:42:04'),
//            array('id' => '242','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-16','time_start' => '02:45','time_end' => '03:19','target' => 'Мінування','coordinates' => '37T CN 08116 98712 (19005)','status' => 'Заміновано','ammunition' => '[{"title":"\\u041e\\u0417\\u041c-72","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-16 03:20:14','updated_at' => '2026-05-16 03:20:14'),
//            array('id' => '243','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-16','time_start' => '03:28','time_end' => '03:46','target' => 'Мінування','coordinates' => '37T CN 07771 93409','status' => 'Не заміновано','ammunition' => '[{"title":"\\u0406\\u0411\\u041c3","quantity":"2"}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-05-16 03:50:48','updated_at' => '2026-05-16 03:50:48'),
//            array('id' => '244','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '6','date' => '2026-05-16','time_start' => '05:53','time_end' => '06:25','target' => 'Укриття','coordinates' => '37Т CN 07096 99722','status' => 'Уражено','ammunition' => '[{"title":"\\u0424\\u0410\\u0411 5","quantity":1},{"title":"\\u0424\\u0410\\u0411 7","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-16 06:28:03','updated_at' => '2026-05-16 06:28:03'),
//            array('id' => '245','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-16','time_start' => '20:45','time_end' => '21:12','target' => 'Перегін борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 06:33:22','updated_at' => '2026-05-17 06:33:22'),
//            array('id' => '246','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-16','time_start' => '22:00','time_end' => '22:31','target' => 'Доставка','coordinates' => '37T CN 02614 99846','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 06:34:36','updated_at' => '2026-05-17 06:34:36'),
//            array('id' => '247','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-17','time_start' => '00:15','time_end' => '00:41','target' => 'Доставка','coordinates' => '37Т СN 01673 99557','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 06:35:15','updated_at' => '2026-05-17 06:35:15'),
//            array('id' => '248','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-17','time_start' => '01:43','time_end' => '02:25','target' => 'Мінування','coordinates' => '37Т СN 07016 99305 (19001)
//37T CP 08334 00092 (19098)','status' => 'Заміновано','ammunition' => '[{"title":"\\u041e\\u0417\\u041c-72","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 06:35:58','updated_at' => '2026-05-17 06:35:58'),
//            array('id' => '249','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-17','time_start' => '03:31','time_end' => '04:13','target' => 'Мінування','coordinates' => '37Т СN 08895 93405
//37T CN 08893 93403','status' => 'Заміновано','ammunition' => '[{"title":"\\u0406\\u0411\\u041c3","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 06:36:55','updated_at' => '2026-05-17 06:36:55'),
//            array('id' => '250','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '6','date' => '2026-05-17','time_start' => '05:38','time_end' => '05:53','target' => 'Укриття','coordinates' => '37Т СP 06971 00449','status' => 'Не уражено (втрата борта)','ammunition' => '[{"title":"\\u041c\\u041e\\u0410-400","quantity":1},{"title":"\\u0424\\u0410\\u0411 7","quantity":1}]','is_drone_lost' => '1','drone_lost_reason' => 'Збито ФПВ','created_at' => '2026-05-17 06:37:41','updated_at' => '2026-05-17 06:37:41'),
//            array('id' => '251','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-17','time_start' => '19:34','time_end' => '19:56','target' => 'Перегін борта','coordinates' => '-','status' => 'Виконано','ammunition' => '[]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 23:24:29','updated_at' => '2026-05-17 23:24:29'),
//            array('id' => '252','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-17','time_start' => '22:18','time_end' => '22:56','target' => 'Доставка','coordinates' => '37T CN 02550 98672','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-17 23:25:11','updated_at' => '2026-05-17 23:25:11'),
//            array('id' => '253','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-18','time_start' => '01:30','time_end' => '01:43','target' => 'Доставка','coordinates' => '37T CP 02106 00400','status' => 'Не доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-18 01:45:44','updated_at' => '2026-05-18 01:45:44'),
//            array('id' => '254','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-18','time_start' => '06:31','time_end' => '06:59','target' => 'Доставка','coordinates' => '37T CP 03271 02893','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-18 06:58:03','updated_at' => '2026-05-18 06:58:03'),
//            array('id' => '255','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-18','time_start' => '07:08','time_end' => '07:31','target' => 'БПЛА','coordinates' => '37Т СР 03225 04356
//37T CP 03236 04354','status' => 'Знищено','ammunition' => '[{"title":"\\u041e\\u0413-\\u04111","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-18 07:29:37','updated_at' => '2026-05-20 02:45:10'),
//            array('id' => '256','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-18','time_start' => '22:21','time_end' => '22:53','target' => 'Доставка','coordinates' => '37T CN 02598 99843','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-18 23:51:07','updated_at' => '2026-05-18 23:51:07'),
//            array('id' => '257','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-19','time_start' => '00:20','time_end' => '00:51','target' => 'Доставка','coordinates' => '37T CP 02106 00400','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 00:51:41','updated_at' => '2026-05-19 00:51:41'),
//            array('id' => '258','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-19','time_start' => '00:56','time_end' => '01:30','target' => 'Мінування','coordinates' => '37T CN 07215 99186 (19023)','status' => 'Заміновано','ammunition' => '[{"title":"\\u041e\\u0417\\u041c-72","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 01:30:45','updated_at' => '2026-05-19 01:30:45'),
//            array('id' => '259','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-19','time_start' => '02:46','time_end' => '03:38','target' => 'Мінування','coordinates' => '37T CN 08073 92663
//37T CN 08072 92661','status' => 'Заміновано','ammunition' => '[{"title":"\\u0406\\u0411\\u041c3","quantity":"2"}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 03:39:58','updated_at' => '2026-05-19 03:39:58'),
//            array('id' => '260','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '1','date' => '2026-05-19','time_start' => '21:39','time_end' => '22:11','target' => 'Укриття','coordinates' => '37T CN 04240 99106','status' => 'Уражено','ammunition' => '[{"title":"Penetrator","quantity":1},{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 22:32:05','updated_at' => '2026-05-19 22:32:05'),
//            array('id' => '261','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '2','date' => '2026-05-19','time_start' => '22:28','time_end' => '22:56','target' => 'Доставка','coordinates' => '37T CP 01420 00054','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 22:57:25','updated_at' => '2026-05-19 22:57:25'),
//            array('id' => '262','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '3','date' => '2026-05-19','time_start' => '23:02','time_end' => '23:30','target' => 'Доставка','coordinates' => '37T CP 02106 00400','status' => 'Доставлено','ammunition' => '[{"title":"\\u041f\\u043e\\u0441\\u0438\\u043b\\u043a\\u0430","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-19 23:30:10','updated_at' => '2026-05-19 23:30:10'),
//            array('id' => '263','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '4','date' => '2026-05-20','time_start' => '00:13','time_end' => '00:44','target' => 'Укриття','coordinates' => '37T CN 04235 99104','status' => 'Уражено','ammunition' => '[{"title":"Penetrator","quantity":1},{"title":"\\u0422\\u041c-2025","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-20 00:44:38','updated_at' => '2026-05-20 00:44:38'),
//            array('id' => '264','shift_id' => '10','user_id' => '7','position' => 'Ланос','flight_number' => '5','date' => '2026-05-20','time_start' => '03:33','time_end' => '04:04','target' => 'Укриття','coordinates' => '37T CN 04240 99106','status' => 'Знищено','ammunition' => '[{"title":"\\u0422\\u041c-14","quantity":1}]','is_drone_lost' => '0','drone_lost_reason' => NULL,'created_at' => '2026-05-20 04:05:45','updated_at' => '2026-05-20 04:05:45')
//        );
//
//        foreach ($flights as $flight) {
//            $flight['status'] = $flight['status'] . ': ' . $flight['coordinates'];
//            echo $flight['status'] . PHP_EOL;
//            $newFlight = new Flight($flight);
//            $newFlight->save();
//        }
    }
}
