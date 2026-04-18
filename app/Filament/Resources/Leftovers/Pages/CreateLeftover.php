<?php

namespace App\Filament\Resources\Leftovers\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use App\Models\Shift;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLeftover extends CreateRecord
{
    protected static string $resource = LeftoverResource::class;

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
        return 'Новий залишок';
    }

    /**
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        $records = [];
        $items = $data['leftover_items'];
        foreach ($items as $item) {
            $records[] = static::getModel()::create([
                'position_id' => Shift::where('navigator_id', auth()->id())
                    ->whereNull('end_date')
                    ->value('position_id'),
                'title' => $item['leftover_title'],
                'quantity' => $item['leftover_quantity'],
                'unit' => $item['leftover_unit'],
                'leftover_on' => $item['leftover_on'],
            ]);
        }
        return current($records);
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
            ->title('Залишок успішно додано')
            ->success();
    }
}
