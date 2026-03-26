<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use Filament\Resources\Pages\Page;

/**
 * Class ReportFlight
 * @package App\Filament\Resources\FlightResource\Pages
 */
class ReportFlight extends Page
{
	/*** @var string */
	protected static string $resource = FlightResource::class;
	/*** @var string */
	protected string $view = 'filament.resources.flight-resource.pages.report-flight';
}
