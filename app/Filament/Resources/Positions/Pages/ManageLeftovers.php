<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use App\Filament\Resources\Positions\PositionResource;
use Filament\Resources\Pages\ManageRelatedRecords;

/**
 *
 */
class ManageLeftovers extends ManageRelatedRecords
{
    /*** @var string */
    protected static string $resource = PositionResource::class;

    /*** @var string */
    protected static string $relationship = 'leftovers';

    /*** @var string|null */
    protected static ?string $relatedResource = LeftoverResource::class;

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Залишки';

    /*** @var string|null */
    protected static ?string $title = 'Залишки';

    /*** @var string|null */
    protected static ?string $breadcrumb = 'Залишки';
}
