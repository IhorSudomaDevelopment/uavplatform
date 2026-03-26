<?php

namespace App\ModelControllers\Repositories;

use App\Models\Ammunition;

class AmmunitionRepository
{
    /*** @return array */
    public function getTitleList(): array
    {
        return Ammunition::all()->pluck('title', 'title')->toArray();
    }
}
