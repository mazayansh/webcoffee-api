<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function save(array $customerDetails)
    {
        return Customer::create($customerDetails);
    }
}
