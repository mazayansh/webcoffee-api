<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getPaginate(array $query_params);
}
