<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Positions\PositionResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPositions extends ListRecords
{
    /*** @var string */
    protected static string $resource = PositionResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Позиції';

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }


    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
