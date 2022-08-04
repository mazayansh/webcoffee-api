<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ShippingInformationServiceInterface;
use App\Http\Resources\ShippingInformationResource;
use App\Helpers\CookieHelper;

class ShippingInfoController extends Controller
{
    public function __construct(
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {

    }

    public function __invoke(Request $request)
    {
        $cartId = CookieHelper::getCookieValue(config('constants.cookie_name.cart'));

        $shippingInfo = $this->shippingInformationService
                                ->getShippingInfo($cartId);

        return new ShippingInformationResource($shippingInfo);
    }
}
