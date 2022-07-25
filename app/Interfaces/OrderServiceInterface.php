<?php

namespace App\Interfaces;

interface OrderServiceInterface
{
    public function createOrder(string $cartId, array $orderDetails);
}
