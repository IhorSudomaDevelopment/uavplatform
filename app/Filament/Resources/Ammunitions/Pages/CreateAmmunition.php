<?php

namespace App\Filament\Resources\Ammunitions\Pages;

use App\Filament\Resources\Ammunitions\AmmunitionResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAmmunition extends CreateRecord
{
    /*** @var string */
    protected static string $resource = AmmunitionResource::class;

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
        return 'Новий БК';
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
