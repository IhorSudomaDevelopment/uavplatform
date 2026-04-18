<?php

namespace App\Filament\Resources\Leftovers;

use App\Filament\Resources\Leftovers\Pages\CreateLeftover;
use App\Filament\Resources\Leftovers\Pages\EditLeftover;
use App\Filament\Resources\Leftovers\Pages\ListLeftovers;
use App\Filament\Resources\Leftovers\Schemas\LeftoverForm;
use App\Filament\Resources\Leftovers\Tables\LeftoversTable;
use App\Models\Leftover;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeftoverResource extends Resource
{
    protected static ?string $model = Leftover::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-archive-box';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Залишки';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 6;
    }

    public static function form(Schema $schema): Schema
    {
        return LeftoverForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeftoversTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeftovers::route('/'),
            'create' => CreateLeftover::route('/create'),
            'edit' => EditLeftover::route('/{record}/edit'),
        ];
    }

    /*** @return bool */
    public static function canCreate(): bool
    {
        return isRoleNavigator();
    }
}
