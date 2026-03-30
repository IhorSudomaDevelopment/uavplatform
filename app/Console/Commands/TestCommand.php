<?php

namespace App\Console\Commands;

use App\Models\Flight;
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
        $shift = DB::table('shifts')
            ->where('navigator_id', Auth::id())
            ->whereNull('end_date')
            ->pluck('navigator_id', 'id')
            ->toArray();
        if (!empty($shift)) {
            print_r($shift);
        }
    }
}
