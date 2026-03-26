<?php

namespace App\Filament\Resources\Drones\Pages;

use App\Filament\Resources\Drones\DroneResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDrones extends ListRecords
{
    protected static string $resource = DroneResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Борти';

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        $actions[] = CreateAction::make()
            ->label('Додати')
            ->icon('heroicon-o-plus');
        return $actions;
    }
}
