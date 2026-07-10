<?php

namespace App\Filament\Resources\Flights\Pages;

use App\Filament\Resources\Flights\FlightResource;
use App\ValuesObject\Target;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

/**
 *
 */
class EditFlight extends EditRecord
{
    /*** @var string */
    protected static string $resource = FlightResource::class;

    /*** @var string|null */
    protected static ?string $title = 'Редагування';

    /*** @return array|Action[]|ActionGroup[] */
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /*** @return string */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /*** @return array|string[] */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('position')->label('Позиція'),
                TextInput::make('date')->label('Дата'),
                TextInput::make('flight_number')->label('Номер'),
                TextInput::make('time_start')->label('Зліт'),
                TextInput::make('time_end')->label('Посадка'),
                Select::make('target')
                    ->options(Target::getList())->label('Ціль'),
                TextInput::make('coordinates')->label('Координати (MGRS)'),
                TextInput::make('personnel_200')->label('ОС, 200'),
                TextInput::make('personnel_300')->label('ОС, 300'),
            ]);
    }
}
