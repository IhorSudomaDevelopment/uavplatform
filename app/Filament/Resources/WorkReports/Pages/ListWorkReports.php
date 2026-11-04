<?php

namespace App\Filament\Resources\WorkReports\Pages;

use App\Filament\Resources\WorkReports\WorkReportResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkReports extends ListRecords
{
    /*** @var string */
    protected static string $resource = WorkReportResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Звіти про роботу';

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
                ->label('Додати')
                ->icon('heroicon-o-plus')
        ];
    }
}
