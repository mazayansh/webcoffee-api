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
}
