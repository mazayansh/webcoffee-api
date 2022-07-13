<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function save(array $userDetails);

    public function isExists(string $column, string $value): bool;
}
