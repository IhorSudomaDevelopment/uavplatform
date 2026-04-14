<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\Models\Position;
use App\Models\Shift;
use App\ValuesObject\Target;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateFlight extends CreateRecord
{
    /*** @var string */
    protected static string $resource = FlightResource::class;

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
        return 'Новий політ';
    }

    /**
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        if (isRoleAdmin() || isRoleManager()) {
            $shift = $data['shift'];
            $shiftData = explode('|', $shift);
            $data['shift_id'] = $shiftData[0];
            $data['position_id'] = $shiftData[1];
            $data['position'] = Position::where('id', $data['position_id'])->value('title');
            $data['user_id'] = Shift::where('id', $data['shift_id'])->value('navigator_id');
        } else {
            $data['shift_id'] = getShiftDetails()['shift_id'];
            $data['user_id'] = auth()->id();
        }
        if (in_array(
            $data['target'],
            [
                Target::CROSSING_BARGE,
                Target::SEARCH_MISSION,
                Target::UAV_EVACUATION,
                Target::UAV_HUNT
            ]
        )) {
            $data['coordinates'] = '-';
        }
        $status = $data['status'];
        if (isset($data['personnel_200']) && $data['personnel_200'] > 0) {
            $status = $status . ', ' . $data['personnel_200'] . ' - 200';
        }
        if (isset($data['personnel_300']) && $data['personnel_300'] > 0) {
            $status = $status . ', ' . $data['personnel_300'] . ' - 300';
        }
        if ($data['is_uav_destroyed']) {
            $status = $status . ', знищено ворожий БпЛА';
        }
        $data['status'] = $status;
        $data = array_merge($data, ['ammunition' => $this->formatAmmunition($data['ammunition_items'] ?? [])]);
        return static::getModel()::create($data);
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

    /**
     * @param array $items
     * @return array
     */
    protected function formatAmmunition(array $items): array
    {
        return array_map(function ($item) {
            return [
                'title' => $item['ammunition'] ?? '-',
                'quantity' => $item['quantity'] ?? 0,
            ];
        }, $items);
    }

    /*** @return Notification|null */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Політ успішно додано')
            ->success();
    }
}
