<?php

namespace App\Services;

use App\Interfaces\BillingAddressRepositoryInterface;
use App\Interfaces\BillingAddressServiceInterface;

class BillingAddressService implements BillingAddressServiceInterface
{
    public function __construct(
        public BillingAddressRepositoryInterface $billingAddressRepository
    )
    {

    }

    public function createBillingAddress(array $billingAddressDetails)
    {
        return $this->billingAddressRepository->save([
            'order_id' => $billingAddressDetails['order_id'],
            'first_name' => $billingAddressDetails['first_name'],
            'last_name' => $billingAddressDetails['last_name'] ?? null,
            'phone' => $billingAddressDetails['phone'] ?? null,
            'address' => $billingAddressDetails['address'],
            'city' => $billingAddressDetails['city'],
            'state' => $billingAddressDetails['state'],
            'postcode' => $billingAddressDetails['postcode'],
        ]);
    }
}
