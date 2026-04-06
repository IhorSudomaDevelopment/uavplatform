<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class MyDashboard extends Page
{
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-home';
    protected string $view = 'filament.pages.my-dashboard';
}
