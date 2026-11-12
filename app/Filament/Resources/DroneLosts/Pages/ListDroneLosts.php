<?php

namespace App\Filament\Resources\DroneLosts\Pages;

use App\Filament\Resources\DroneLosts\DroneLostResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDroneLosts extends ListRecords
{
    /*** @var string */
    protected static string $resource = DroneLostResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Втрачені борти';

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
