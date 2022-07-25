<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Interfaces\CartItemServiceInterface;
use App\Http\Resources\CartItemResource;
use App\Helpers\CookieHelper;

class CartController extends Controller
{
    public function __construct(
        public CartItemServiceInterface $cartItemService
    )
    {
        
    }

    public function show()
    {
        $cartId = CookieHelper::getCookieValue(config('constants.cookie_name.cart'));
        $cartItems = $this->cartItemService->getListFromCart($cartId);

        return response()
                ->json([
                    'data' => CartItemResource::collection($cartItems)
                ], 200);
    }
}
