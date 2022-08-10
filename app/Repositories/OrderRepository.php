<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function getPaginateByUser(string $userId)
    {
        return Order::where('user_id',$userId)
                    ->with(['orderItems','orderItems.productVariant.product','orderItems.productVariant.product.medias'])
                    ->paginate(20);
    }

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

    public function getById(string $orderId)
    {
        return Order::findOrFail($orderId)->load(['orderItems','orderItems.productVariant','orderItems.productVariant.product.medias','shipping']);
    }
}
