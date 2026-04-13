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
        $q = Flight::where('position', 'Ланос')
            ->where('date', '<=', '2026-04-13')
            ->where('date', '=>', '2026-04-02')
            ->get()
            ->toArray();
        print_r($q);
    }
}
