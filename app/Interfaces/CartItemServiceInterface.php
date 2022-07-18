<?php

namespace App\Interfaces;

interface CartItemServiceInterface
{
    public function getListFromCart(string $cartId);

    public function addToCart(string $cartId, array $cartItemDetails);

    public function updateCartItem(string $cartItemId, array $cartItemDetails);

    public function removeFromCart(string $cartItemId): bool;
}