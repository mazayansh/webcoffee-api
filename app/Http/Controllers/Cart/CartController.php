<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveShippingAddressRequest;
use App\Interfaces\{
    CartServiceInterface,
    CartItemServiceInterface,
    ShippingInformationServiceInterface
};
use App\Http\Resources\CartItemResource;
use App\Helpers\CookieHelper;

class CartController extends Controller
{
    public function __construct(
        public CartServiceInterface $cartService, 
        public CartItemServiceInterface $cartItemService,
        public ShippingInformationServiceInterface $shippingInformationService
    )
    {
        
    }

    public function store()
    {
        return response()->json([], 200)->withCookie(
                $this->cartService->generateCartCookie()
            );
    }

    public function show()
    {
        $cartId = request()->cookie(config('constants.cookie_name.cart')) 
                    ?? 
                    CookieHelper::getCookieValueFromQueue(config('constants.cookie_name.cart'));
        $cartItems = $this->cartItemService->getListFromCart($cartId);

        return response()
                ->json([
                    'data' => CartItemResource::collection($cartItems)
                ], 200);
    }

    public function checkout(SaveShippingAddressRequest $request)
    {
        $cartId = request()->cookie(config('constants.cookie_name.cart')) 
                    ?? 
                    CookieHelper::getCookieValueFromQueue(config('constants.cookie_name.cart'));

        $isCartNotEmpty = $this->cartService->isCartNotEmpty($cartId);

        if ($isCartNotEmpty) {
            $shippingable = [
                'id' => $cartId,
                'type' => 'cart'
            ];

            $shippingInfo = $this->shippingInformationService
                                ->create(
                                    $shippingable,
                                    $request->validated()
                                );
            
            $response = [
                'content' => [
                    'message' => 'Shipping address sucessfully saved',
                    'shipping_address' => $shippingInfo
                ],
                'code' => 201
            ];
        } else {
            $response = [
                'content' => [
                    'message' => 'Your cart is empty. Please add our special coffee product to your cart first.',
                ],
                'code' => 400
            ];
        }

        return response()->json($response['content'], $response['code']);
    }
}
