<?php

namespace App\Repositories;

use App\Interfaces\ShippingInformationRepositoryInterface;
use App\Models\ShippingInformation;

class ShippingInformationRepository implements ShippingInformationRepositoryInterface
{
    public function save(array $shippingable, array $shippingInfoDetails)
    {
        $model = null;
        switch ($shippingable['type']) {
            case 'cart':
                $model = \App\Models\Cart::findOrFail($shippingable['id']);
                break;
            case 'order':
                $model = \App\Models\Order::findOrFail($shippingable['id']);
                break;
        }

        return $model->shipping()->create($shippingInfoDetails);
    }

    public function getByShippingableId(string $shippingableId)
    {
        return ShippingInformation::findOrFail($shippingableId);
    }
}
