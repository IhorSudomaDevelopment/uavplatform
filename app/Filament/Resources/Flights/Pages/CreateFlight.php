<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\Models\Drone;
use App\Models\DroneLost;
use App\Models\Leftover;
use App\Models\Position;
use App\ValuesObject\DroneStatus;
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
        $status200 = $status300 = $additionalStatus200 = $additionalStatus300 = 0;
        $targetsWithoutCoordinates = [
            Target::CROSSING_BARGE,
            Target::SEARCH_MISSION,
            Target::EVACUATION_MISSION,
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
            $data['main_coordinates'] = implode(', ', $coordinates);
            $data['main_status'] = $statuses;
            /* ADDITIONAL */
            $additionalCoordinates = [];
            $additionalStatuses = [];
            if (isset($data['additional_coordinate_items'])) {
                foreach ($data['additional_coordinate_items'] as $additionalCoordinateItem) {
                    if (!isset($additionalCoordinateItem['additional_coordinate_status_200'], $additionalCoordinateItem['additional_coordinate_status_300'])) {
                        $additionalCoordinateItem['additional_coordinate_status_200'] = 0;
                        $additionalCoordinateItem['additional_coordinate_status_300'] = 0;
                    }
                    $additionalCoordinates[] = $additionalCoordinateItem['additional_coordinate_item'];
                    $additionalStatusParts = [];
                    if ($additionalCoordinateItem['additional_coordinate_status_200'] > 0) {
                        $additionalStatusParts[] =
                            $additionalCoordinateItem['additional_coordinate_status_200'] . ' - 200';
                        $additionalStatus200 += $additionalCoordinateItem['additional_coordinate_status_200'];
                    }
                    if ($additionalCoordinateItem['additional_coordinate_status_300'] > 0) {
                        $additionalStatusParts[] =
                            $additionalCoordinateItem['additional_coordinate_status_300'] . ' - 300';
                        $additionalStatus300 += $additionalCoordinateItem['additional_coordinate_status_300'];
                    }
                    $additionalAdditionalInfo = !empty($additionalStatusParts)
                        ? ' (' . implode(', ', $additionalStatusParts) . ')'
                        : '';
                    $additionalStatuses[] =
                        $additionalCoordinateItem['additional_coordinate_status']
                        . $additionalAdditionalInfo
                        . ': '
                        . $additionalCoordinateItem['additional_coordinate_item'];
                }
                $data['additional_coordinates'] = implode(', ', $additionalCoordinates);
                $data['additional_status'] = $additionalStatuses;
            }
            /* END ADDITIONAL */
        }
        if (isset($data['additional_coordinates'])) {
            $generalCoords = $data['main_coordinates'] . ' (' . $data['target'] . ')' . PHP_EOL . $data['additional_coordinates'] . ' (' . $data['additional_target'] . ')';
            $generalStatus = array_merge($data['main_status'], $data['additional_status']);
        } else {
            $generalCoords = $data['main_coordinates'];
            $generalStatus = $data['main_status'];
        }
        $data['coordinates'] = $generalCoords;
        $data['status'] = $generalStatus;
        if (!empty($data['is_uav_destroyed'])) {
            $data['status'][] = 'знищено ворожий БпЛА';
        }
        $data['personnel_200'] = $status200 + $additionalStatus200;
        $data['personnel_300'] = $status300 + $additionalStatus300;
        $data['ammunition'] = $this->formatAmmunition(
            $data['position'],
            $data['ammunition_items'] ?? []
        );
        unset($data['ammunition_items'], $data['coordinate_items']);
        if ($data['is_drone_lost']) {
            $drone = Drone::whereId($data['drone_lost_sn_with_id'])->first();
            $drone->update(['status' => DroneStatus::LOST]);
            $droneLost = new DroneLost();
            $droneLost->fill([
                'drone_id' => $drone->id,
                'drone_sn' => $drone->serial_number,
                'date' => $data['date'],
                'time' => $data['time_end'],
                'lost_coords' => $data['drone_lost_coords'],
                'lost_reason' => $data['drone_lost_reason'],
            ]);
            $droneLost->save();
        }

        //TODO TESTING
//        $workReport = WorkReport::query()->where('date', $data['shift'])->first();
//        if ($workReport === null) {
//            $workReport = new WorkReport();
//            $workReport->user_id = $data['user_id'];
//            $workReport->position = $data['position'];
//            $workReport->crew = '';
//            $workReport->date = $data['shift'];
//            $workReport->save();
//        }

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
