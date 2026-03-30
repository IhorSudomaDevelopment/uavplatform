<?php

namespace App\Filament\Resources\Shifts;

use App\Filament\Resources\Shifts\Pages\CreateShift;
use App\Filament\Resources\Shifts\Pages\EditShift;
use App\Filament\Resources\Shifts\Pages\ListShifts;
use App\Filament\Resources\Shifts\Schemas\ShiftForm;
use App\Filament\Resources\Shifts\Tables\ShiftsTable;
use App\Models\Shift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ShiftResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Shift::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Зміни';


    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 3;
    }

    public static function form(Schema $schema): Schema
    {
        return ShiftForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShiftsTable::configure($table);
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
            'index' => ListShifts::route('/'),
            'create' => CreateShift::route('/create'),
            'edit' => EditShift::route('/{record}/edit'),
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
