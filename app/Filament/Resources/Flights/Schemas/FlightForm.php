<?php

namespace App\Filament\Resources\Flights\Schemas;

use App\ValuesObject\DroneLostReason;
use App\ValuesObject\Target;
use App\ValuesObject\TargetStatus;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class FlightForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        if (isRoleNavigator()) {
            $num = DB::table('flights')
                ->whereDate('date', now('Europe/Kyiv'))
                ->where('user_id', auth()->id())
                ->max('flight_number');
            $num = ($num ?? 0) + 1;
        } else {
            $num = 1;
        }
        return $schema
            ->columns()
            ->components([
                TextInput::make('position')
                    ->label('Позиція')
                    ->default(getDefaultPosition() ?? getShiftDetails()['position_name'])
                    ->required(),
                TextInput::make('flight_number')
                    ->label('Номер')
                    ->default($num)
                    ->required(),
                TextInput::make('date')
                    ->label('Дата')
                    ->default(now('Europe/Kyiv')->format('Y-m-d'))
                    ->required(),
                Fieldset::make('Час польоту')
                    ->schema([
                        TextInput::make('time_start')
                            ->label('Зліт')
                            ->required(),
                        TextInput::make('time_end')
                            ->label('Посадка')
                            ->required(),
                    ])
                    ->columns()
                    ->columnSpanFull(),
                Select::make('target')
                    ->label('Ціль')
                    ->required()
                    ->options(Target::getList())
                    ->reactive(),
                Textarea::make('coordinates')
                    ->label('Координати (MGRS)')
                    ->required(),
                Select::make('status')
                    ->label('Статус по цілі')
                    ->required()
                    ->options(TargetStatus::getList())
                    ->reactive(),
                Fieldset::make('200 / 300')
                    ->schema([
                        TextInput::make('personnel_200')
                            ->label('200')
                            ->default(0),
                        TextInput::make('personnel_300')
                            ->label('300')
                            ->default(0),
                    ])
                    ->visible(fn(Get $get) => in_array($get('target'), [Target::PERSONNEL, Target::SHELTER]) &&
                        in_array($get('status'), [TargetStatus::DESTROYED, TargetStatus::AFFECTED])) // умова
                    ->columnSpanFull(),
                Fieldset::make('БК')
                    ->schema([
                        Repeater::make('ammunition_items')
                            ->hiddenLabel()
                            ->schema([
                                Fieldset::make('')
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('ammunition')
                                            ->label('Назва')
                                            ->required()
                                            ->options(ammunitionController()->getTitleList()),
                                        TextInput::make('quantity')
                                            ->label('Кількість')
                                            ->required()
                                            ->default(1),
                                    ]),
                            ])
                            ->addActionLabel('Додати')
                            ->columnSpanFull()
                            ->collapsible(),
                    ])->visible(fn(Get $get) => $get('target') !== Target::CROSSING_BARGE)
                    ->columnSpanFull(),
                Checkbox::make('is_drone_lost')
                    ->label('Втрата борта')
                    ->live(),
                Select::make('drone_lost_reason')
                    ->label('Причина втрати борта')
                    ->options(fn(Get $get) => $get('is_drone_lost') ? DroneLostReason::getList() : [])
                    ->visible(fn(Get $get) => $get('is_drone_lost'))
                    ->columnSpanFull(),
            ]);
    }
}
