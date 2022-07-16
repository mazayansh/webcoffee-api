<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;

class CartRepository implements CartRepositoryInterface
{
    public function save(array $cartDetails)
    {
        return Cart::create($cartDetails);
    }
}
