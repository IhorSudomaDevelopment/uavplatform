<?php

namespace App\Filament\Resources\DroneLosts\Pages;

use App\Filament\Resources\DroneLosts\DroneLostResource;
use App\Models\Drone;
use App\Models\Position;
use App\ValuesObject\DroneStatus;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateDroneLost extends CreateRecord
{
    /*** @var string */
    protected static string $resource = DroneLostResource::class;

    /*** @var bool */
    protected static bool $canCreateAnother = false;

    /**
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['drone_lost_sn_with_id'])) {
            $drone = Drone::whereId($data['drone_lost_sn_with_id'])->first();
            $drone->update(['status' => DroneStatus::LOST]);
            $data['drone_id'] = $drone->id;
            $data['drone_sn'] = $drone->serial_number;
        }
        return static::getModel()::create($data);
    }

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
