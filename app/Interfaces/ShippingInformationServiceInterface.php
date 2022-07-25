<?php

namespace App\Interfaces;

interface ShippingInformationServiceInterface
{
    public function create(array $shippingable, array $shippingInfoDetails);

    public function getShippingInfo(string $shippingableId);

    public function addShippingMethod(
                        string $shippingableId, 
                        array $shippingMethodDetails);
                        
    public function getShippingCost(string $shippingableId, string $shippingMethod);
    
    public function updateShippingInfo(string $shippingableId, array $shippingInfoDetails);
}