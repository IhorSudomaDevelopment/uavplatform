<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

/**
 *
 */
class WorkReport extends Page
{
    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-document-chart-bar';

    /*** @var string */
    protected string $view = 'filament.pages.test-resource';

    /*** @var string|null */
    protected static ?string $title = '';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Звіти про роботу';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 5;
    }
}
