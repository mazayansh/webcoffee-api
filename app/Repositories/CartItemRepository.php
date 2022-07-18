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

    public function save(array $cartItemDetails)
    {
        return CartItem::create($cartItemDetails);
    }

    public function update(int $cartItemId, array $cartItemDetails): bool
    {
        try {
            return CartItem::findOrFail($cartItemId)->update($cartItemDetails);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function remove(int $cartItemId): bool
    {
        try {
            return CartItem::findOrFail($cartItemId)->delete();
        } catch (\Throwable $th) {
            return false;
        }
    }
}
