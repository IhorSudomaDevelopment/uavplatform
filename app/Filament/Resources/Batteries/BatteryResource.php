<?php

namespace App\Filament\Resources\Batteries;

use App\Filament\Resources\Batteries\Pages\CreateBattery;
use App\Filament\Resources\Batteries\Pages\EditBattery;
use App\Filament\Resources\Batteries\Pages\ListBatteries;
use App\Filament\Resources\Batteries\Schemas\BatteryForm;
use App\Filament\Resources\Batteries\Tables\BatteriesTable;
use App\Models\Battery;
use App\Models\Position;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BatteryResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Battery::class;

    /*** @var string|BackedEnum|null */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bolt';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'АКБ';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 6;
    }

    public static function form(Schema $schema): Schema
    {
        return BatteryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BatteriesTable::configure($table);
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
            'index' => ListBatteries::route('/'),
            'create' => CreateBattery::route('/create'),
            'edit' => EditBattery::route('/{record}/edit'),
        ];
    }

    /*** @return Builder */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (isRoleNavigator()) {
            $positionWithUser = Position::where('user_id', Auth::id())->first();
            if ($positionWithUser !== null) {
                $query->where('position_id', $positionWithUser->id);
            }
        }
        return $query;
    }
}
