<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
    public function save(array $customerDetails);
}
