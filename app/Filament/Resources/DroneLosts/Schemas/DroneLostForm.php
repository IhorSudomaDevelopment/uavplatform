<?php

namespace App\Filament\Resources\DroneLosts\Schemas;

use Filament\Schemas\Schema;

class DroneLostForm
{
    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
