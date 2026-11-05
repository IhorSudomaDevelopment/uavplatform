<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class RequestTemplate extends Page
{
    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-clipboard-document-list';

    /*** @var string */
    protected string $view = 'filament.pages.template-request';

    /*** @var string|null */
    protected static ?string $title = '';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Заявка';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 10;
    }
}
