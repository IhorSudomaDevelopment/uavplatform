<?php

namespace App\Filament\Resources\Flights\Schemas;

use App\Models\Position;
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
        return $schema
            ->columns()
            ->components([
                Select::make('position')
                    ->label('Позиція')
                    ->placeholder('Вибрати')
                    ->options(Position::all()->pluck('title', 'title'))
                    ->required(),
                TextInput::make('flight_number')
                    ->label('Номер')
                    ->default(1)
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
                    ->placeholder('Вибрати')
                    ->required()
                    ->options(Target::getList())
                    ->reactive(),
                Select::make('status')
                    ->label('Статус')
                    ->placeholder('Вибрати')
                    ->required()
                    ->options(fn(Get $get) => TargetStatus::getStatusListForTarget($get('target') ?? 'all'))
                    ->visible(fn(Get $get) => in_array(
                        $get('target'),
                        [
                            Target::CROSSING_BARGE => Target::CROSSING_BARGE,
                            Target::SEARCH_MISSION => Target::SEARCH_MISSION,
                            Target::UAV_EVACUATION => Target::UAV_EVACUATION,
                            // Target::UAV_HUNT
                        ])),

                // -- TEST NEW COORDS INPUTS WITH STATUSES --
                Fieldset::make('Координати (MGRS) та статус по цілі')
                    ->schema([
                        Repeater::make('coordinate_items')
                            ->hiddenLabel()
                            ->schema([
                                Fieldset::make('')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextInput::make('coordinate_item')
                                            ->label('Координати')
                                            ->required(),
                                        Select::make('coordinate_status')
                                            ->label('Статус по цілі')
                                            ->placeholder('Вибрати')
                                            ->required()
                                            ->options(fn(Get $get) => TargetStatus::getStatusListForTarget($get('../../target') ?? 'all'))
                                            ->reactive(),
                                        TextInput::make('coordinate_status_200')
                                            ->label('ОС, 200')
                                            ->default(0)
                                            ->visible(fn(Get $get) => in_array($get('../../target'), [Target::PERSONNEL, Target::SHELTER], true)),
                                        TextInput::make('coordinate_status_300')
                                            ->label('ОС, 300')
                                            ->default(0)
                                            ->visible(fn(Get $get) => in_array($get('../../target'), [Target::PERSONNEL, Target::SHELTER], true)),
                                    ])->columns(4),
                            ])
                            ->addActionLabel('Додати')
                            ->columnSpanFull()
                            ->collapsible(),
                    ])->visible(fn(Get $get) => !in_array(
                        $get('target'),
                        [
                            Target::CROSSING_BARGE,
                            Target::SEARCH_MISSION,
                            Target::UAV_EVACUATION,
                            Target::UAV_HUNT
                        ]))
                    ->columnSpanFull(),
                //
//                Fieldset::make('200 / 300')
//                    ->schema([
//                        TextInput::make('personnel_200')
//                            ->label('200')
//                            ->default(0),
//                        TextInput::make('personnel_300')
//                            ->label('300')
//                            ->default(0),
//                    ])
//                    ->visible(fn(Get $get) => in_array($get('target'), [Target::PERSONNEL, Target::SHELTER]) &&
//                        in_array($get('status'), [TargetStatus::DESTROYED, TargetStatus::AFFECTED])) // умова
//                    ->columnSpanFull(),
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
                                            ->placeholder('Вибрати')
                                            ->required()
                                            ->options(ammunitionController()->getTitleList()),
                                        TextInput::make('quantity')
                                            ->label('Кількість')
                                            ->required()
                                            ->default(1),
                                        Select::make('detonation')
                                            ->label('Детонація')
                                            ->placeholder('Вибрати')
                                            ->required()
                                            ->options([
                                                'Детон' => 'Детон',
                                                'Не детон' => 'Не детон',
                                                '-' => '-'
                                            ]),
                                    ])->columns(3)
                            ])
                            ->addActionLabel('Додати')
                            ->columnSpanFull()
                            ->collapsible(),
                    ])->visible(fn(Get $get) => $get('target') !== Target::CROSSING_BARGE)
                    ->columnSpanFull(),
                TextInput::make('commentar')
                    ->label('Коментар'),
                Checkbox::make('is_uav_destroyed')
                    ->label('Знищено ворожий БпЛА'),
                Checkbox::make('is_drone_lost')
                    ->label('Втрата борта')
                    ->live(),
                Select::make('drone_lost_reason')
                    ->label('Причина втрати борта')
                    ->placeholder('Вибрати')
                    ->options(fn(Get $get) => $get('is_drone_lost') ? DroneLostReason::getList() : [])
                    ->visible(fn(Get $get) => $get('is_drone_lost'))
                    ->columnSpanFull(),
            ]);
    }
}
