<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function getPaginateByUser(string $userId);

    public function save(array $orderDetails);

    public function update(string $orderId, array $orderDetails);

    public function getById(string $orderId);
}
