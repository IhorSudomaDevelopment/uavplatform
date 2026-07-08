<?php

namespace App\Http\Controllers;

use App\Models\Leftover;
use App\Models\Position;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    public function leftovers(Position $position): View
    {
        $leftovers = Leftover::query()
            ->where('position_id', $position->id)
            ->orderBy('title')
            ->get();

        return view('reports.leftovers', [
            'position'  => $position,
            'leftovers' => $leftovers,
        ]);
    }
}
