<?php

namespace App\Filament\Resources\Batteries\Pages;

use App\Filament\Resources\Batteries\BatteryResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBatteries extends ListRecords
{
    /*** @var string */
    protected static string $resource = BatteryResource::class;

    /*** @var string|null */
    protected static ?string $title = 'АКБ';

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
