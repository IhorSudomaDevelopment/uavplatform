<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reports/leftovers/{position}', [ReportController::class, 'leftovers'])
    ->name('reports.leftovers');
