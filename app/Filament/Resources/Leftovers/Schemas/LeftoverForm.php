<?php

namespace App\Filament\Resources\Leftovers\Schemas;

use App\Models\Ammunition;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
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
        return $schema
            ->columns(3)
            ->components([
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
                                            ->required()
                                            ->options($preparedList),
                                        TextInput::make('leftover_quantity')
                                            ->label('Кількість')
                                            ->required()
                                            ->default(1),
                                        Select::make('leftover_unit')
                                            ->label('Одиниці')
                                            ->required()
                                            ->options(['шт' => 'шт', 'л' => 'л']),
                                        TextInput::make('leftover_on')
                                            ->label('Залишок на')
                                            ->required()
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
