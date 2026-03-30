<?php

namespace App\Filament\Resources\Shifts\Pages;

use App\Filament\Resources\Shifts\ShiftResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateShift extends CreateRecord
{
    protected static string $resource = ShiftResource::class;

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
        return 'Нова зміна';
    }

//    /**
//     * @param array $data
//     * @return Model
//     */
//    protected function handleRecordCreation(array $data): Model
//    {
//
//        $data['start_date'] = $status;
//        $data = array_merge($data, [
//            'user_id' => auth()->id(),
//            'ammunition' => $this->formatAmmunition($data['ammunition_items'] ?? []),
//        ]);
//        return static::getModel()::create($data);
//    }

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
            ->title('Зміну успішно додано')
            ->success();
    }
}
