<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function save(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function isExists(string $column, string $value): bool
    {
        return User::where($column, $value)->exists();
    }
}