<?php

namespace App\Filament\Resources\Positions;

use App\Filament\Resources\Positions\Pages\CreatePosition;
use App\Filament\Resources\Positions\Pages\EditPosition;
use App\Filament\Resources\Positions\Pages\ListPositions;
use App\Filament\Resources\Positions\Schemas\PositionForm;
use App\Filament\Resources\Positions\Tables\PositionsTable;
use App\Models\Position;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class PositionResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Position::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-map-pin';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Позиції';


    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 2;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return PositionForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return PositionsTable::configure($table);
    }

    /*** @return array|\class-string[]|RelationGroup[]|RelationManagerConfiguration[] */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /*** @return array|PageRegistration[] */
    public static function getPages(): array
    {
        return [
            'index' => ListPositions::route('/'),
            'create' => CreatePosition::route('/create'),
            'edit' => EditPosition::route('/{record}/edit'),
        ];
    }

    /*** @return bool */
    public static function canCreate(): bool
    {
        return isRoleAdmin() || isRoleManager();
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canEdit(Model $record): bool
    {
        return isRoleAdmin() || isRoleManager();
    }

    /*** @return bool */
    public static function shouldRegisterNavigation(): bool
    {
        return isRoleAdmin() || isRoleManager();
    }
}
