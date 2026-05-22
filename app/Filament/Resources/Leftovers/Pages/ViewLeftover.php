<?php

namespace App\Filament\Resources\Leftovers\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

/**
 *
 */
class ViewLeftover extends ViewRecord
{
    /*** @var string */
    protected static string $resource = LeftoverResource::class;

    /*** @return array|Actions\Action[]|Actions\ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
