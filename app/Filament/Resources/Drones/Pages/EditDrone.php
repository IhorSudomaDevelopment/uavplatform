<?php

namespace App\Filament\Resources\Drones\Pages;

use App\Filament\Resources\Drones\DroneResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 *
 */
class EditDrone extends EditRecord
{
    /*** @var string */
    protected static string $resource = DroneResource::class;

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
