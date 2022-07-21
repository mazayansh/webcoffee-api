<?php

namespace App\Interfaces;

interface ShippingInformationRepositoryInterface
{
    public function save(array $shippingable, array $shippingInfoDetails);

    public function getByShippingableId(string $shippingableId);

    public function updateByShippingableId(
                        string $shippingableId, 
                        array $shippingInfoDetails
                    );
}
