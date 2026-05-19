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
        $flight = Flight::where('id', 6)->first();
        $p['s'] = 1;
        $count = 0;
        $positions = [];
        $offset = 0;
        while (($pos = strpos($flight->coordinates, '37T', $offset)) !== false) {
            $positions[] = $pos;
            $offset = $pos + 1;
            $count++;
        }
        if ($count >= 2) {
            $p['s'] += $count - 1;
        }
        echo $p['s'];
    }
}
