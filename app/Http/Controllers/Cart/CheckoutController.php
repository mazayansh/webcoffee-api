<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Interfaces\ShippingInformationServiceInterface;
use App\Http\Requests\SaveShippingAddressRequest;
use App\Helpers\CookieHelper;

class CheckoutController extends Controller
{
    public function __construct(
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {

    }

    public function __invoke(SaveShippingAddressRequest $request)
    {
        $cartId = CookieHelper::getCookieValue(config('constants.cookie_name.cart'));
        $shippingable = [
            'id' => $cartId,
            'type' => 'cart'
        ];

        $shippingInfo = $this->shippingInformationService
                                ->create(
                                    $shippingable,
                                    $request->validated()
                                );

        return response()->json([
            'message' => 'Shipping address sucessfully saved',
            'shipping_address' => $shippingInfo
        ], 201);
    }
}
