<?php

namespace App\Filament\Resources\DroneLosts\Pages;

use App\Filament\Resources\DroneLosts\DroneLostResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDroneLost extends CreateRecord
{
    /*** @var string */
    protected static string $resource = DroneLostResource::class;

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
        return 'Додати втрату';
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
