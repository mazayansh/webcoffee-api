<?php

namespace App\Services;

use App\Interfaces\ShippingInformationServiceInterface;
use App\Interfaces\ShippingInformationRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Http;

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

    public function getShippingCost(
                        string $shippingableId, 
                        string $shippingMethod)
    {
        $shippingOptions = $this->fetchShippingOptions($shippingableId);

        $shippingCost = 0;
        
        if ($shippingOptions) {
            $costs = $shippingOptions[0]->costs;
            
            for ($j=0;$j<count($costs);$j++) {
                if ($costs[$j]->service == $shippingMethod) {
                    $shippingCost = $costs[$j]->cost[0]->value;
                    break;
                }
            }
        }

        return $shippingCost;
    }

    public function getShippingMethodList(string $shippingableId)
    {
        $shippingOptions = $this->fetchShippingOptions($shippingableId);

        $shippingMethods = [];

        if ($shippingOptions) {
            $costs = $shippingOptions[0]->costs;
                
            for ($j=0;$j<count($costs);$j++) {
                $shippingMethods[$j] = [
                    'shipping_method' => $costs[$j]->service,
                    'shipping_description' => $costs[$j]->description,
                    'shipping_cost' => $costs[$j]->cost[0]->value,
                    'shipping_estimated_days' => $costs[$j]->cost[0]->etd
                ];
            }
        }

        return $shippingMethods;
    }

    public function updateShippingInfo(string $shippingableId, array $shippingInfoDetails)
    {
        $shippingInfo = $this->shippingInformationRepository
                            ->updateByShippingableId($shippingableId, $shippingInfoDetails);

        if (! $shippingInfo) {
            throw new \Exception("Update shipping information failed");
        }

        return $shippingInfo;
    }

    private function fetchShippingOptions(string $shippingableId)
    {
        $originCode = config('constants.shipping.origin_code');
        $destinationCode = $this->getShippingInfo($shippingableId)->city_code;
        $weight = $this->cartRepository->getSumCartItemsWeight($shippingableId);

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->asForm()->post(env('RAJAONGKIR_API_URL').'/cost', [
            'origin' => $originCode,
            'destination' => $destinationCode,
            'weight' => $weight,
            'courier' => config('constants.shipping.courier')
        ]);

        return json_decode($response)->rajaongkir->results;
    }
}
