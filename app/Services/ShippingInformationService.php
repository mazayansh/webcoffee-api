<?php

namespace App\Services;

use App\Interfaces\ShippingInformationServiceInterface;
use App\Interfaces\ShippingInformationRepositoryInterface;

class ShippingInformationService implements ShippingInformationServiceInterface
{
    public function __construct(
        public ShippingInformationRepositoryInterface $shippingInformationRepository
    )
    {

    }

    public function create(array $shippingable, array $shippingInfoDetails)
    {
        return $this->shippingInformationRepository->save($shippingable, $shippingInfoDetails);
    }

    public function getShippingInfo(string $shippingableId)
    {
        return $this->shippingInformationRepository->getByShippingableId($shippingableId);
    }
}
