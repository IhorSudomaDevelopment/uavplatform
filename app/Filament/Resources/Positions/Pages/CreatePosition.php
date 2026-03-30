<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Positions\PositionResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePosition extends CreateRecord
{
    /*** @var string */
    protected static string $resource = PositionResource::class;

    /*** @var bool */
    protected static bool $canCreateAnother = FALSE;

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /*** @return string */
    public function getTitle(): string
    {
        return 'Нова позиція';
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

    /*** @return Notification|null */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Позицію успішно додано')
            ->success();
    }
}
