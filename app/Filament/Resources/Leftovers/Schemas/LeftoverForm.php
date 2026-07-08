<?php

namespace App\Filament\Resources\Leftovers\Schemas;

use App\Models\Ammunition;
use App\Models\Position;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

/**
 *
 */
class LeftoverForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        $preparedList = [];
        $list = Ammunition::all()->pluck('title', 'title')->toArray();
        foreach ($list as $key => $value) {
            if (!in_array($value, ['-', 'БпЛА Вампір'])) {
                $preparedList[$key] = $value;
            }
        }
        $preparedList['Бензин'] = 'Бензин';
        $preparedList['ДП'] = 'ДП';
        $preparedList['Вода (пак)'] = 'Вода (пак)';
        $preparedList['Сухий пайок'] = 'Сухий пайок';
        return $schema
            ->columns(3)
            ->components([
                Select::make('position_id')
                    ->label('Позиція')
                    ->placeholder('Вибрати')
                    ->options(Position::all()->pluck('title', 'id')->toArray())
                    ->required()
                    ->visible(fn(Get $get) => isRoleAdmin() || isRoleManager()),
                Fieldset::make('Перелік')
                    ->schema([
                        Repeater::make('leftover_items')
                            ->hiddenLabel()
                            ->schema([
                                Fieldset::make('')
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('leftover_title')
                                            ->label('Назва')
                                            ->placeholder('Вибрати')
                                            ->required()
                                            ->options($preparedList),
                                        TextInput::make('leftover_quantity')
                                            ->label('Кількість')
                                            ->required()
                                            ->default(1),
                                        Select::make('leftover_unit')
                                            ->label('Одиниці')
                                            ->placeholder('Вибрати')
                                            ->required()
                                            ->options(['шт' => 'шт', 'л' => 'л'])
                                            ->default('шт'),
                                    ]),
                            ])
                            ->addActionLabel('Додати')
                            ->columnSpanFull()
                            ->collapsible(),
                    ])
                    ->columnSpanFull(),
                //->visible(fn(Get $get) => isRoleAdmin() || isRoleManager()),
//                TextInput::make('position')
//                    ->label('Позиція')
//                    ->default(getDefaultPosition() ?? getShiftDetails()['position_name'])
//                    ->required()
//                    ->visible(fn(Get $get) => isRoleNavigator()),
            ]);
    }
}
