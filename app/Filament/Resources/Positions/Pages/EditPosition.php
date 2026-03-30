<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Positions\PositionResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPosition extends EditRecord
{
    /*** @var string */
    protected static string $resource = PositionResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Редагування';

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /*** @return string */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }
}
