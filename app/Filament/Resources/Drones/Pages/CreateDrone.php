<?php

namespace App\Filament\Resources\Drones\Pages;

use App\Filament\Resources\Drones\DroneResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDrone extends CreateRecord
{
    protected static string $resource = DroneResource::class;

    /*** @var bool */
    protected static bool $canCreateAnother = false;

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /*** @return string */
    public function getTitle(): string
    {
        return 'Новий борт';
    }

    /*** @return Action */
    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Створити');
    }

    /*** @return Action */
    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Відхилити');
    }

    /*** @return string */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /*** @return string */
    protected function getCreatedRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
