<?php

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function getAllByCartId(string $cartId)
    {
        return CartItem::where('cart_id', $cartId)->with([
            'productVariant','productVariant.product'
            ])->get();
    }
}
