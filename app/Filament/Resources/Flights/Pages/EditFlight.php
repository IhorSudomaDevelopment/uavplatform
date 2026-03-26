<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 *
 */
class EditFlight extends EditRecord
{
    /*** @var string */
    protected static string $resource = FlightResource::class;

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /*** @return string */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
