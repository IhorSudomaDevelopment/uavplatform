<?php

namespace App\Filament\Resources\Logs;

use App\Filament\Resources\Logs\Pages\CreateLog;
use App\Filament\Resources\Logs\Pages\EditLog;
use App\Filament\Resources\Logs\Pages\ListLogs;
use App\Filament\Resources\Logs\Schemas\LogForm;
use App\Filament\Resources\Logs\Tables\LogsTable;
use App\Models\Log;
use BackedEnum;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class LogResource extends Resource
{
    /*** @var string|null */
    protected static ?string $model = Log::class;

    /*** @var string|BackedEnum|Heroicon|null */
    protected static string|BackedEnum|null|Heroicon $navigationIcon = Heroicon::OutlinedRectangleStack;

    /*** @var string|null */
    protected static ?string $navigationLabel = 'Логи';

    /*** @return int */
    public static function getNavigationSort(): int
    {
        return 9;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return LogForm::configure($schema);
    }

    /**
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return LogsTable::configure($table);
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
            'index' => ListLogs::route('/'),
            'create' => CreateLog::route('/create'),
            'edit' => EditLog::route('/{record}/edit'),
        ];
    }

    /*** @return bool */
    public static function canCreate(): bool
    {
        return false;
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canEdit(Model $record): bool
    {
        return false;
    }

    /**
     * @param Model $record
     * @return bool
     */
    public static function canDelete(Model $record): bool
    {
        return false;
    }

    /*** @return bool */
    public static function shouldRegisterNavigation(): bool
    {
        return isRoleAdmin();
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Інформація')
                    ->columns()
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Дата')
                            ->dateTime('d.m.Y H:i:s'),

                        TextEntry::make('user.name')
                            ->label('Користувач'),

                        TextEntry::make('model')
                            ->label('Модель'),

                        TextEntry::make('model_id')
                            ->label('ID'),

                        TextEntry::make('action')
                            ->label('Дія')
                            ->badge(),
                    ]),

                Section::make('Інформація про запит')
                    ->icon('heroicon-o-computer-desktop')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('ip')
                            ->label('IP-адреса')
                            ->icon('heroicon-o-globe-alt')
                            ->copyable(),

                        TextEntry::make('user_agent')
                            ->label('User-Agent')
                            ->copyable()
                            ->wrap()
                            ->columnSpanFull(),
                    ]),

                Section::make('Зміни')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([

                                Section::make('Було')
                                    ->icon('heroicon-o-arrow-left')
                                    ->schema([
                                        KeyValueEntry::make('old_values')
                                            ->hiddenLabel()
                                            ->state(function ($record) {

                                                if (empty($record->old_values)) {
                                                    return [];
                                                }

                                                $labels = [
                                                    'id' => 'ID',
                                                    'sn' => 'Серійний номер',
                                                    'name' => 'Назва',
                                                    'title' => 'Назва',
                                                    'status' => 'Статус',
                                                    'password' => 'Пароль',
                                                    'position_id' => 'Позиція',
                                                    'created_at' => 'Створено',
                                                    'updated_at' => 'Оновлено',
                                                    'serial_number' => 'Серійний №',
                                                    'additional_info' => 'Додаткова інформація',
                                                    'starlink_serial_number' => 'Starlink №',
                                                    'kit' => 'KIT',
                                                    'time_start' => 'Зліт',
                                                    'time_end' => 'Посадка',
                                                    'target' => 'Ціль',
                                                    'quantity' => 'Кількість',
                                                    'unit' => 'Одининці',
                                                    'position' => 'Позиція',
                                                    'flight_number' => 'Номер польоту'
                                                ];

                                                return collect($record->old_values)
                                                    ->mapWithKeys(function ($value, $key) use ($labels) {
                                                        return [
                                                                $labels[$key] ?? ucfirst(str_replace('_', ' ', $key))
                                                            => is_array($value)
                                                                ? json_encode($value, JSON_UNESCAPED_UNICODE)
                                                                : $value,
                                                        ];
                                                    })
                                                    ->toArray();
                                            }),
                                    ]),

                                Section::make('Стало')
                                    ->icon('heroicon-o-arrow-right')
                                    ->schema([
                                        KeyValueEntry::make('new_values')
                                            ->hiddenLabel()
                                            ->state(function ($record) {

                                                if (empty($record->new_values)) {
                                                    return [];
                                                }

                                                $labels = [
                                                    'id' => 'ID',
                                                    'sn' => 'Серійний номер',
                                                    'name' => 'Назва',
                                                    'title' => 'Назва',
                                                    'status' => 'Статус',
                                                    'password' => 'Пароль',
                                                    'position_id' => 'Позиція',
                                                    'created_at' => 'Створено',
                                                    'updated_at' => 'Оновлено',
                                                    'serial_number' => 'Серійний №',
                                                    'additional_info' => 'Додаткова інформація',
                                                    'starlink_serial_number' => 'Starlink №',
                                                    'kit' => 'KIT',
                                                    'time_start' => 'Зліт',
                                                    'time_end' => 'Посадка',
                                                    'target' => 'Ціль',
                                                    'quantity' => 'Кількість',
                                                    'unit' => 'Одининці',
                                                    'position' => 'Позиція',
                                                    'flight_number' => 'Номер польоту'
                                                ];

                                                return collect($record->new_values)
                                                    ->mapWithKeys(function ($value, $key) use ($labels) {
                                                        return [
                                                                $labels[$key] ?? ucfirst(str_replace('_', ' ', $key))
                                                            => is_array($value)
                                                                ? json_encode($value, JSON_UNESCAPED_UNICODE)
                                                                : $value,
                                                        ];
                                                    })
                                                    ->toArray();
                                            }),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
