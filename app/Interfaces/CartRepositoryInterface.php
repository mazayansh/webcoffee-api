<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function save(array $cartDetails);
}
