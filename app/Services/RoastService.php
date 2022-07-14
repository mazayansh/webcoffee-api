<?php

namespace App\Services;

use App\Interfaces\{
    RoastServiceInterface,
    RoastRepositoryInterface
};

class RoastService implements RoastServiceInterface
{
    public function __construct(public RoastRepositoryInterface $roastRepository)
    {

    }

    public function getList()
    {
        return $this->roastRepository->getAll();
    }
}
