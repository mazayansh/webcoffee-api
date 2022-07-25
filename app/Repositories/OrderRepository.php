<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function save(array $orderDetails)
    {
        return Order::create($orderDetails);
    }

    public function update(string $orderId, array $orderDetails)
    {
        try {
            return Order::findOrFail($orderId)->update($orderDetails);
        } catch (\Exception $e) {
            return false;
        }
    }
}
