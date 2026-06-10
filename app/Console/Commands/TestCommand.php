<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\Shift;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpMath\MGRS\MGRS;

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
        $mgrsCoords = '35U PU 12345 67890';

        $utmZone = substr($mgrsCoords, 0, 2);
        $mgrsCoordsWithoutUtmZone = str_replace(' ', '', substr($mgrsCoords, 2));

        $latitudeBand = substr($mgrsCoordsWithoutUtmZone, 0, 1);
        $mgrsCoordsWithoutUtmZoneAndLatitudeBand = str_replace(' ', '', substr($mgrsCoordsWithoutUtmZone, 1));

        $gridSquare = substr($mgrsCoordsWithoutUtmZoneAndLatitudeBand, 0, 2);
        $mgrsCoordsWithoutUtmZoneAndLatitudeBandAndGridSquare = substr($mgrsCoordsWithoutUtmZoneAndLatitudeBand, 2);

        $easting = substr($mgrsCoordsWithoutUtmZoneAndLatitudeBandAndGridSquare, 0, 5);
        $northing = substr($mgrsCoordsWithoutUtmZoneAndLatitudeBandAndGridSquare, 5);

//        echo $utmZone . PHP_EOL;
//        echo $latitudeBand . PHP_EOL;
//        echo $gridSquare . PHP_EOL;
//        echo $easting . PHP_EOL;
//        echo $mgrsCoordsWithoutUtmZoneAndLatitudeBandAndGridSquareAndEasting . PHP_EOL;

        $zoneGroup1 = ['ABCDEFGH'];
        $zoneGroup2 = ['JKLMNPQR'];
        $zoneGroup3 = ['STUVWXYZ'];

        $groupNumber = $utmZone % 3;

        $positionData = [
            'J' => 1,
            'K' => 2,
            'L' => 3,
            'M' => 4,
            'N' => 5,
            'P' => 6,
            'Q' => 7,
            'R' => 8,
        ];

        $letterValue1 = null;

        $gridSquareLetter1 = substr($gridSquare, 0, 1);
        $gridSquareLetter2 = substr($gridSquare, 1, 2);
        foreach ($positionData as $key => $value) {
            if ($gridSquareLetter1 === $key) {
                $letterValue1 = $value;
            }
        }
        if ($letterValue1 !== null) {
            $baseEasting = $letterValue1 * 100000;
        }
        $lines = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V'];

        $position = array_search($gridSquareLetter2, $lines);
        $baseNorthing = $position * 10000;

        $factEasting = $baseEasting + (int)$easting;
        $factNorthing = $baseNorthing + (int)$northing;
        $bandZoneU = '48°N – 56°N';
        $bandMinNorthingForUtmZone = 5310000;

        while ($factNorthing < $bandMinNorthingForUtmZone) {
            $factNorthing += 2000000;
        }

        $a = 6378137.0;
        $f = 1 / 298.257223563;
        $e2 = $f * (2 - $f);

        $x = $factEasting - 500000;
        $y = $factNorthing;

        $lon0 = ((int)$utmZone - 1) * 6 - 180 + 3;

        echo $x . PHP_EOL;
        echo $y . PHP_EOL;
        echo $lon0 . PHP_EOL;
    }
}
