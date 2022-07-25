<?php

namespace App\Repositories;

use App\Interfaces\BillingAddressRepositoryInterface;
use App\Models\BillingAddress;

class BillingAddressRepository implements BillingAddressRepositoryInterface
{
    public function save(array $billingAddressDetails)
    {
        return BillingAddress::create($billingAddressDetails);
    }
}