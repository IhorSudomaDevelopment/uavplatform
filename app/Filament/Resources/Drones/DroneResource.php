<?php

namespace App\Filament\Resources\Drones;

use App\Filament\Resources\Drones\Pages\CreateDrone;
use App\Filament\Resources\Drones\Pages\EditDrone;
use App\Filament\Resources\Drones\Pages\ListDrones;
use App\Filament\Resources\Drones\Schemas\DroneForm;
use App\Filament\Resources\Drones\Tables\DronesTable;
use App\Models\Drone;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

/**
 *
 */
class DroneResource extends Resource
{
    /**
     * @var string|null
     */
    protected static ?string $model = Drone::class;

    /**
     * @var string|BackedEnum|null
     */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Борти';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 3;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return DroneForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return DronesTable::configure($table);
    }

    /*** @return array|class-string[]|RelationGroup[]|RelationManagerConfiguration[] */
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
            'index' => ListDrones::route('/'),
            'create' => CreateDrone::route('/create'),
            'edit' => EditDrone::route('/{record}/edit'),
        ];
    }
}
