<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

/**
 *
 */
class MyDashboard extends Page
{
    /*** @var string|BackedEnum|null */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-home';

    /*** @var string */
    protected string $view = 'filament.pages.my-dashboard';
}
