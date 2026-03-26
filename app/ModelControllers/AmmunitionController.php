<?php

namespace App\ModelControllers;

use App\ModelControllers\Repositories\AmmunitionRepository;

class AmmunitionController
{
    /*** @var AmmunitionRepository */
    public AmmunitionRepository $repo;

    /**
     * AmmunitionController constructor.
     * @param AmmunitionRepository $repo
     */
    public function __construct(AmmunitionRepository $repo)
    {
        $this->repo = $repo;
    }

    /*** @return array */
    public function getTitleList(): array
    {
        return $this->repo->getTitleList();
    }
}
