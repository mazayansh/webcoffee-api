<?php

namespace App\Services;

use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    public function __construct(public OrderRepositoryInterface $orderRepository)
    {
        
    }
}
