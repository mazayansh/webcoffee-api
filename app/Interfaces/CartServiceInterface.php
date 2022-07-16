<?php

namespace App\Interfaces;

interface CartServiceInterface
{
    public function create();
    
    public function getCartCookie();

    public function generateCartCookie(string $cartId);
}
