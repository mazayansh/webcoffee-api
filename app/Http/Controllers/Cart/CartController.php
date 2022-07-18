<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\{
    CartServiceInterface,
    CartItemServiceInterface
};
use App\Http\Resources\CartItemResource;

class CartController extends Controller
{
    private $cartCookie;

    public function __construct(
        public CartServiceInterface $cartService, 
        public CartItemServiceInterface $cartItemService
    )
    {
        $this->cartCookie = $this->cartService->getCartCookie();
    }

    public function store()
    {
        return response()->json([], 200)->withCookie($this->cartCookie);
    }

    public function show()
    {
        $cartId = $this->cartCookie->getValue();
        $cartItems = $this->cartItemService->getListFromCart($cartId);

        return response()
                ->json([
                    'data' => CartItemResource::collection($cartItems)
                ], 200)
                ->withCookie($this->cartCookie);
    }
}
