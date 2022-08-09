<?php

namespace App\Interfaces;

interface OrderServiceInterface
{
    public function getListPaginate(string $userId);

    public function createOrder(string $cartId, array $orderDetails);

    public function updateOrder(string $orderId, array $orderDetails);

    public function getOrder(string $orderId);
}
