<?php

namespace App\Services;

use App\Interfaces\RoastServiceInterface;
use App\Interfaces\RoastRepositoryInterface;

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
