<?php

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Models\CartItem;

class CartItemRepository implements CartItemRepositoryInterface
{
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

    public function getAllByCartId(string $cartId)
    {
        return CartItem::where('cart_id', $cartId)->with([
            'productVariant','productVariant.product','productVariant.product.medias'
            ])->get();
    }

    public function checkIfCartHaveItems(string $cartId): bool
    {
        return CartItem::where('cart_id', $cartId)->exists();
    }

    public function moveToOrderItemsTable($cartItems, $order): bool
    {
        try {
            $cartItems->each(function ($cartItem) use ($order) {
                $orderItem = $cartItem->replicate(['cart_id']);
                $orderItem->order_id = $order->id;
                $orderItem->subtotal_price = $cartItem->productVariant->price * $cartItem->quantity;
                $orderItem->setTable('order_items');
                $orderItem->save();

                $cartItem->delete();
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
