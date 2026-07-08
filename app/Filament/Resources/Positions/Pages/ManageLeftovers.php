<?php

namespace App\Filament\Resources\Positions\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use App\Filament\Resources\Positions\PositionResource;
use Filament\Resources\Pages\ManageRelatedRecords;

class ManageLeftovers extends ManageRelatedRecords
{
    protected static string $resource = PositionResource::class;

    protected static string $relationship = 'leftovers';

    protected static ?string $relatedResource = LeftoverResource::class;

    protected static ?string $navigationLabel = 'Залишки';

    protected static ?string $title = 'Залишки';

    protected static ?string $breadcrumb = 'Залишки';
}
