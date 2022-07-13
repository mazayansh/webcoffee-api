<?php

namespace App\Repositories;

use App\Interfaces\TypeRepositoryInterface;
use App\Models\Type;

class TypeRepository implements TypeRepositoryInterface
{
    public function getAll()
    {
        return Type::all();
    }
}
