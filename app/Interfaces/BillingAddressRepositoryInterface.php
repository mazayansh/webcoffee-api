<?php

namespace App\Interfaces;

interface BillingAddressRepositoryInterface
{
    public function save(array $billingAddressDetails);
}
