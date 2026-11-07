<?php

namespace App\Filament\Resources\Ammunitions\Pages;

use App\Filament\Resources\Ammunitions\AmmunitionResource;
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
class EditAmmunition extends EditRecord
{
    /*** @var string */
    protected static string $resource = AmmunitionResource::class;

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
                TextInput::make('description')->label('Опис'),
                TextInput::make('weight')->label('Вага'),
                TextInput::make('box_weight')->label('Вага ящика'),
            ]);
    }
}
