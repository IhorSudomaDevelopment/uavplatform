<?php

namespace App\Filament\Resources\Ammunitions;

use App\Filament\Resources\Ammunitions\Pages\CreateAmmunition;
use App\Filament\Resources\Ammunitions\Pages\EditAmmunition;
use App\Filament\Resources\Ammunitions\Pages\ListAmmunitions;
use App\Filament\Resources\Ammunitions\Schemas\AmmunitionForm;
use App\Filament\Resources\Ammunitions\Tables\AmmunitionsTable;
use App\Models\Ammunition;
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
class AmmunitionResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Ammunition::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-rocket-launch';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Боєкомплект';

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
        return AmmunitionForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return AmmunitionsTable::configure($table);
    }

    /*** @return array|class-string[]|RelationGroup[]|RelationManagerConfiguration[] */
    public static function getRelations(): array
    {
        return [];
    }

    /*** @return array|PageRegistration[] */
    public static function getPages(): array
    {
        return [
            'index' => ListAmmunitions::route('/'),
            'create' => CreateAmmunition::route('/create'),
            'edit' => EditAmmunition::route('/{record}/edit'),
        ];
    }

    /*** @return bool */
    public static function shouldRegisterNavigation(): bool
    {
        return isRoleAdmin() || isRoleManager();
    }
}
