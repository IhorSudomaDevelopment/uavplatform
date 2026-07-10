<?php

namespace App\Filament\Resources\Leftovers\Pages;

use App\Filament\Resources\Leftovers\LeftoverResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

/**
 *
 */
class EditLeftover extends EditRecord
{
    /*** @var string */
    protected static string $resource = LeftoverResource::class;

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
                TextInput::make('title')->label('Назва'),
                TextInput::make('quantity')->label('Кількість'),
                TextInput::make('unit')->label('Одиниця'),
            ]);
    }
}
