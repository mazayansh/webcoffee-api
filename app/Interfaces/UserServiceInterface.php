<?php

namespace App\Interfaces;

interface UserServiceInterface
{
    public function register(array $requestData);

    public function login(array $requestData);

    public function refreshToken();
}
