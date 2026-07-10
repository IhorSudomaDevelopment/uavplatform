<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\Models\Leftover;
use App\Models\Position;
use App\ValuesObject\Target;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
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
        $data['user_id'] = auth()->id();
        $data['status'] = [];
        $status200 = 0;
        $status300 = 0;
        $targetsWithoutCoordinates = [
            Target::CROSSING_BARGE,
            Target::SEARCH_MISSION,
            Target::UAV_EVACUATION,
        ];
        if (in_array($data['target'], $targetsWithoutCoordinates, true)) {
            $data['coordinates'] = '-';
        } else {
            $coordinates = [];
            $statuses = [];
            foreach ($data['coordinate_items'] as $coordinateItem) {
                if (!isset($coordinateItem['coordinate_status_200'], $coordinateItem['coordinate_status_300'])) {
                    $coordinateItem['coordinate_status_200'] = 0;
                    $coordinateItem['coordinate_status_300'] = 0;
                }
                $coordinates[] = $coordinateItem['coordinate_item'];
                $statusParts = [];
                if ($coordinateItem['coordinate_status_200'] > 0) {
                    $statusParts[] =
                        $coordinateItem['coordinate_status_200'] . ' - 200';
                    $status200 += $coordinateItem['coordinate_status_200'];
                }
                if ($coordinateItem['coordinate_status_300'] > 0) {
                    $statusParts[] =
                        $coordinateItem['coordinate_status_300'] . ' - 300';
                    $status300 += $coordinateItem['coordinate_status_300'];
                }
                $additionalInfo = !empty($statusParts)
                    ? ' (' . implode(', ', $statusParts) . ')'
                    : '';
                $statuses[] =
                    $coordinateItem['coordinate_status']
                    . $additionalInfo
                    . ': '
                    . $coordinateItem['coordinate_item'];
            }
            $data['coordinates'] = implode(', ', $coordinates);
            $data['status'] = $statuses;
        }
        if (!empty($data['is_uav_destroyed'])) {
            $data['status'][] = 'знищено ворожий БпЛА';
        }
        $data['personnel_200'] = $status200;
        $data['personnel_300'] = $status300;
        $data['ammunition'] = $this->formatAmmunition(
            $data['position'],
            $data['ammunition_items'] ?? []
        );
        unset($data['ammunition_items'], $data['coordinate_items']);
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
     * @param string $position
     * @param array $items
     * @return array
     */
    protected function formatAmmunition(string $position, array $items): array
    {
        $position = Position::where('title', $position)->first();
        $leftovers = Leftover::where('position_id', $position->id)->get();
        foreach ($leftovers as $leftover) {
            foreach ($items as $item) {
                if ($leftover->title === $item['ammunition']) {
                    $leftover->quantity -= $item['quantity'];
                    $leftover->save();
                }
            }
        }
        return array_map(function ($item) {
            return [
                'title' => $item['ammunition'] ?? '-',
                'quantity' => $item['quantity'] ?? 0,
                'detonation' => $item['detonation'],
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
