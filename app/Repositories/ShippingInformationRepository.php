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

        return $model->shipping()->updateOrCreate(['shippingable_id' => $shippingable['id']], $shippingInfoDetails);
    }

    public function getByShippingableId(string $shippingableId)
    {
        return ShippingInformation::where('shippingable_id', $shippingableId)->first();
    }

    public function updateByShippingableId(
                        string $shippingableId, 
                        array $shippingInfoDetails
    )
    {
        $shippingInfo = ShippingInformation::where(
                                        'shippingable_id', 
                                        $shippingableId
                                    )->first();
        $shippingInfo->update($shippingInfoDetails);

        return $shippingInfo->fresh();
    }
}
