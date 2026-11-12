<?php

namespace App\Filament\Resources\DroneLosts;

use App\Filament\Resources\DroneLosts\Pages\CreateDroneLost;
use App\Filament\Resources\DroneLosts\Pages\EditDroneLost;
use App\Filament\Resources\DroneLosts\Pages\ListDroneLosts;
use App\Filament\Resources\DroneLosts\Schemas\DroneLostForm;
use App\Filament\Resources\DroneLosts\Tables\DroneLostsTable;
use App\Models\DroneLost;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

/**
 *
 */
class DroneLostResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = DroneLost::class;

    /*** @var string|BackedEnum|null */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-no-symbol';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Втрачені борти';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 7;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return DroneLostForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return DroneLostsTable::configure($table);
    }

    /*** @return array|class-string[]|RelationGroup[]|RelationManagerConfiguration[] */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * @return array|PageRegistration[]
     */
    public static function getPages(): array
    {
        return [
            'index' => ListDroneLosts::route('/'),
            'create' => CreateDroneLost::route('/create'),
            'edit' => EditDroneLost::route('/{record}/edit'),
        ];
    }
}
