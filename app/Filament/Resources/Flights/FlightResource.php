<?php

namespace App\Filament\Resources\Flights;

use App\Filament\Resources\Flights\Pages\CreateFlight;
use App\Filament\Resources\Flights\Pages\EditFlight;
use App\Filament\Resources\Flights\Pages\ListFlights;
use App\Filament\Resources\Flights\Schemas\FlightForm;
use App\Filament\Resources\Flights\Tables\FlightsTable;
use App\Models\Flight;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class FlightResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Flight::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-list-bullet';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Польоти';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 4;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return FlightForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return FlightsTable::configure($table);
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
            'index' => ListFlights::route('/'),
            'create' => CreateFlight::route('/create'),
            'edit' => EditFlight::route('/{record}/edit'),
            'report' => Pages\ReportFlight::route('/{record}/report'),
        ];
    }

    /*** @return bool */
    public static function canCreate(): bool
    {
        $shift = DB::table('shifts')
            ->where('navigator_id', Auth::id())
            ->whereNull('end_date')
            ->pluck('navigator_id', 'id')
            ->toArray();
        return isRoleAdmin() || (isRoleNavigator() && ! empty($shift));
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canEdit(Model $record): bool
    {
        return isRoleAdmin() || isRoleManager();
    }

    /**
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (isRoleNavigator()) {
            $query->where('user_id', Auth::id());
        }
        return $query->orderBy('date');
    }
}
