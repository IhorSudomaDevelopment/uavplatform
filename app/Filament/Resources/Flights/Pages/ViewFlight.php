<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

/**
 *
 */
class ViewFlight extends ViewRecord
{
    /*** @var string */
    protected static string $resource = FlightResource::class;

    /*** @return array|Actions\Action[]|Actions\ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
