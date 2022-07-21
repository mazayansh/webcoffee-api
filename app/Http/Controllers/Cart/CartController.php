<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    SaveShippingAddressRequest,
    SaveShippingMethodRequest
};
use App\Interfaces\{
    CartServiceInterface,
    CartItemServiceInterface,
    ShippingInformationServiceInterface
};
use App\Http\Resources\CartItemResource;
use App\Helpers\CookieHelper;

class CartController extends Controller
{
    private string $cartId;

    public function __construct(
        public CartServiceInterface $cartService, 
        public CartItemServiceInterface $cartItemService,
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {
        
    }

    public function show()
    {
        $cartId = $this->getCartId();
        $cartItems = $this->cartItemService->getListFromCart($cartId);

        return response()
                ->json([
                    'data' => CartItemResource::collection($cartItems)
                ], 200);
    }

    public function checkout(SaveShippingAddressRequest $request)
    {
        $cartId = $this->getCartId();
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

    public function shipping(SaveShippingMethodRequest $request)
    {
        $cartId = $this->getCartId();
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

    private function getCartId(): string
    {
        $cookieName = config('constants.cookie_name.cart');
        return request()->cookie($cookieName) ?? 
                CookieHelper::getCookieValueFromQueue($cookieName);
    }
}
