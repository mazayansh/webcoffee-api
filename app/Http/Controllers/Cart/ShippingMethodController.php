<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Interfaces\ShippingInformationServiceInterface;
use App\Http\Requests\SaveShippingAddressRequest;
use App\Helpers\CookieHelper;

class ShippingMethodController extends Controller
{
    public function __construct(
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {

    }

    public function __invoke()
    {
        $cartId = CookieHelper::getCookieValue(config('constants.cookie_name.cart'));
        $shippingable = [
            'id' => $cartId,
            'type' => 'cart'
        ];

        $shippingMethods = $this->shippingInformationService
                                ->getShippingMethodList($shippingable['id']);

        return response()->json([
            'data' => $shippingMethods
        ], 200);
    }
}
