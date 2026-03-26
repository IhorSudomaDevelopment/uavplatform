<?php

namespace App\Filament\Resources\Ammunitions\Pages;

use App\Filament\Resources\Ammunitions\AmmunitionResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 *
 */
class EditAmmunition extends EditRecord
{
    /*** @var string */
    protected static string $resource = AmmunitionResource::class;

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
}
