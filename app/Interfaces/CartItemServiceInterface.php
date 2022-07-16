<?php

namespace App\Interfaces;

interface CartItemServiceInterface
{
    public function getListFromCart(string $cartId);
}