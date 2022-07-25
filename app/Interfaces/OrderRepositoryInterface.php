<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function save(array $orderDetails);
}
