<?php

namespace App\Interfaces;

interface BillingAddressServiceInterface
{
    public function createBillingAddress(array $billingAddressDetails);
}
