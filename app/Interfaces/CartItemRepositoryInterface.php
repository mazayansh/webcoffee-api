<?php

namespace App\Interfaces;

interface CartItemRepositoryInterface
{
    public function getAllByCartId(string $cartId);
}