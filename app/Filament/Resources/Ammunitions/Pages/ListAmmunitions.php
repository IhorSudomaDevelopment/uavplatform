<?php

namespace App\Filament\Resources\Ammunitions\Pages;

use App\Filament\Resources\Ammunitions\AmmunitionResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAmmunitions extends ListRecords
{
    /*** @var string */
    protected static string $resource = AmmunitionResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Боєкомплект';

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
