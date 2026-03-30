<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Settings extends Page
{
    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-cog-6-tooth';

    /*** @var string */
    protected string $view = 'filament.pages.settings';

    /*** @var string|null */
    protected static ?string $title = 'Налаштування';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Налаштування';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 7;
    }
}
