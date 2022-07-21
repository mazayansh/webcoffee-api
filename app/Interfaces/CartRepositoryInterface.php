<?php

namespace App\Interfaces;

interface CartRepositoryInterface
{
    public function save(array $cartDetails);

    public function getSumCartItemsWeight(string $cartId);
}
