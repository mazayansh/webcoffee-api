<?php

namespace App\Interfaces;

interface ShippingInformationServiceInterface
{
    public function create(array $shippingable, array $shippingInfoDetails);

    public function getShippingInfo(string $shippingableId);
}