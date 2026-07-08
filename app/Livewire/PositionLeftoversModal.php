<?php

namespace App\Livewire;

use App\Models\Ammunition;
use App\Models\Leftover;
use App\Models\Position;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

/**
 *
 */
class PositionLeftoversModal extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    /*** @var Position */
    public Position $position;

    /**
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
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

        return $table
            ->query(fn(): Builder => Leftover::query()
                ->where('position_id', $this->position->id)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Кількість'),

                TextColumn::make('unit')
                    ->label('Одиниця'),

                TextColumn::make('leftover_on')
                    ->label('Станом на'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('report')
                    ->label('Звіт')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn () => route('reports.leftovers', [
                        'position' => $this->position->id,
                    ]))
                    ->openUrlInNewTab(),
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        $data['position_id'] = $this->position->id;

                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        Select::make('title')
                            ->label('Назва')
                            ->options($preparedList)
                            ->required(),

                        TextInput::make('quantity')
                            ->label('Кількість')
                            ->numeric()
                            ->required(),

                        Select::make('unit')
                            ->label('Одиниця')
                            ->options([
                                'шт' => 'шт',
                                'л' => 'л',
                            ])
                            ->required(),

                        TextInput::make('leftover_on')
                            ->label('Залишок на')
                            ->required(),
                    ]),
                DeleteAction::make()
                    ->modalHeading('Видалити залишок')
                    ->modalDescription('Ви впевнені, що хочете видалити цей залишок?')
                    ->modalSubmitActionLabel('Видалити')
                    ->modalCancelActionLabel('Скасувати')
                    ->successNotificationTitle('Залишок успішно видалено')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->emptyStateHeading('Залишків не знайдено')
            ->emptyStateDescription('Створіть перший залишок.');
    }

    /*** @return View */
    public function render(): View
    {
        return view('livewire.position-leftovers-modal');
    }

    /**
     * @param Position $position
     * @return void
     */
    public function mount(Position $position): void
    {
        $this->position = $position;
    }
}
