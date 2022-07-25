<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Interfaces\ShippingInformationServiceInterface;
use App\Http\Requests\SaveShippingMethodRequest;
use App\Helpers\CookieHelper;

class ShippingController extends Controller
{
    public function __construct(
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {

    }

    public function __invoke(SaveShippingMethodRequest $request)
    {
        $cartId = CookieHelper::getCookieValue(config('constants.cookie_name.cart'));
        $shippingInfo = $this->shippingInformationService
                                ->addShippingMethod(
                                    $cartId,
                                    $request->validated()
                                );

        return response()->json([
                'message' => 'Shipping method sucessfully saved',
                'shipping_info' => $shippingInfo
            ], 200);
    }
}
