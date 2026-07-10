<?php

namespace App\Filament\Resources\Drones\Pages;

use App\Filament\Resources\Drones\DroneResource;
use App\Models\Position;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class CreateDrone extends CreateRecord
{
    /*** @var string */
    protected static string $resource = DroneResource::class;

    /*** @var bool */
    protected static bool $canCreateAnother = false;

    /**
     * @param array $data
     * @return Model
     */
    protected function handleRecordCreation(array $data): Model
    {
        if (isset($data['position_id'])) {
            $positionId = $data['position_id'];
        } else {
            $positionWithUser = Position::where('user_id', Auth::id())->first();
            if ($positionWithUser !== null) {
                $positionId = $positionWithUser->id;
            }
        }
        $data['serial_number'] = str_replace(' ', '', $data['serial_number']);
        $data['position_id'] = $positionId;
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
