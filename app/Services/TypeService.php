<?php

namespace App\Services;

use App\Interfaces\TypeServiceInterface;
use App\Interfaces\TypeRepositoryInterface;

class TypeService implements TypeServiceInterface
{
    public function __construct(public TypeRepositoryInterface $typeRepository)
    {

    }

    public function getList()
    {
        return $this->typeRepository->getAll();
    }
}
