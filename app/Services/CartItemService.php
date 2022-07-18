<?php

namespace App\Services;

use App\Interfaces\{
    CartItemServiceInterface,
    CartItemRepositoryInterface
};

class CartItemService implements CartItemServiceInterface
{
    public function __construct(public CartItemRepositoryInterface $cartItemRepository)
    {
        
    }

    public function getListFromCart(string $cartId)
    {
        return $this->cartItemRepository->getAllByCartId($cartId);
    }

    public function addToCart(string $cartId, array $cartItemDetails)
    {
        return $this->cartItemRepository->save(
                ['cart_id' => $cartId] + $cartItemDetails
            );
    }

    public function updateCartItem(string $cartItemId, array $cartItemDetails)
    {
        return $this->cartItemRepository->update($cartItemId, $cartItemDetails);
    }

    public function removeFromCart(string $cartItemId): bool
    {
        return $this->cartItemRepository->remove($cartItemId);
    }
}
