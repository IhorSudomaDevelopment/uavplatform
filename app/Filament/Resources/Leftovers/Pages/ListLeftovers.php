<?php

namespace App\Filament\Resources\Leftovers\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 *
 */
class ListLeftovers extends ListRecords
{
    /**
     * @var string
     */
    protected static string $resource = LeftoverResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Залишки на позиції';

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => static::getResource()::canCreate()),
        ];
    }
}
