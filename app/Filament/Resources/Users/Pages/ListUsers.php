<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

/**
 *
 */
class ListUsers extends ListRecords
{

    /*** @var string */
    protected static string $resource = UserResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Користувачі';

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
