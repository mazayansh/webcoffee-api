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

    public function getSumCartItemsWeight(string $cartId)
    {
        return Cart::find($cartId)
                    ->load('cartItems.productVariant')
                    ->cartItems->reduce(
                        function ($carry, $item) {
                            return $carry + $item->productVariant->weight;
                        }, 0
                    );
    }
}
