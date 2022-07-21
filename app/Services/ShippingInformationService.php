<?php

namespace App\Services;

use App\Interfaces\ShippingInformationServiceInterface;
use App\Interfaces\ShippingInformationRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingInformationService implements ShippingInformationServiceInterface
{
    public function __construct(
        public ShippingInformationRepositoryInterface $shippingInformationRepository,
        public CartRepositoryInterface $cartRepository
    )
    {

    }

    public function create(array $shippingable, array $shippingInfoDetails)
    {
        return $this->shippingInformationRepository
                    ->save($shippingable, $shippingInfoDetails);
    }

    public function getShippingInfo(string $shippingableId)
    {
        return $this->shippingInformationRepository
                    ->getByShippingableId($shippingableId);
    }

    public function addShippingMethod(
                        string $shippingableId, 
                        array $shippingMethodDetails)
    {
        $shippingCost = $this->getShippingCost($shippingableId, $shippingMethodDetails['shipping_method']);
        
        $shippingMethodDetails = array_merge($shippingMethodDetails,['shipping_cost' => $shippingCost]);

        return $this->shippingInformationRepository
                    ->updateByShippingableId(
                        $shippingableId, 
                        $shippingMethodDetails
                    );
    }

    private function getShippingCost(
                        string $shippingableId, 
                        string $shippingMethod)
    {
        $originCode = config('constants.shipping.origin_code');
        $destinationCode = $this->getShippingInfo($shippingableId)->city_code;
        $weight = $this->cartRepository->getSumCartItemsWeight($shippingableId);

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->asForm()->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $originCode,
            'destination' => $destinationCode,
            'weight' => $weight,
            'courier' => config('constants.shipping.courier')
        ]);

        $shippingCost = 10000;
        
        if ($results = json_decode($response)->rajaongkir->results) {
            for ($i=0;$i<count($results);$i++) {
                $costs = $results[0]->costs;
                
                for ($j=0;$j<count($costs);$j++) {
                    if ($costs[$j]->service == $shippingMethod) {
                        $shippingCost = $costs[$j]->cost[0]->value;
                        break;
                    }
                }
            }
        }

        return $shippingCost;
    }
}
