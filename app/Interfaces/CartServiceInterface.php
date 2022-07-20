<?php

namespace App\Interfaces;

interface CartServiceInterface
{
    public function create();

    public function generateCartCookie();

    public function isCartNotEmpty(string $cartId): bool;
}
