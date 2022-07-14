<?php

namespace App\Services;

use App\Interfaces\{
    TypeServiceInterface,
    TypeRepositoryInterface
};

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
