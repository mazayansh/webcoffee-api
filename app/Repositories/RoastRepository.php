<?php

namespace App\Repositories;

use App\Interfaces\RoastRepositoryInterface;
use App\Models\Roast;

class RoastRepository implements RoastRepositoryInterface
{
    public function getAll()
    {
        return Roast::all();
    }
}
