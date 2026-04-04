<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class UserResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = User::class;

    /*** @var string|null|BackedEnum */
    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-users';

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Користувачі';

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
        return UserForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
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
}
