<?php

namespace App\Interfaces;

interface CartItemRepositoryInterface
{
    public function getAllByCartId(string $cartId);

    public function save(array $cartItemDetails);

    public function update(int $cartItemId, array $cartItemDetails): bool;

    public function remove(int $cartItemId): bool;
}