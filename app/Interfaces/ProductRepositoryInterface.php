<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getPaginate(array $queryParams);

    public function getById(int $id);
}
