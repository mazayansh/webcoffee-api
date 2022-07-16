<?php

namespace App\Services;

use App\Interfaces\{
    CartServiceInterface,
    CartRepositoryInterface
};

class CartService implements CartServiceInterface
{
    public function __construct(public CartRepositoryInterface $cartRepository)
    {

    }

    public function create()
    {
        $cart = $this->cartRepository->save([
            'user_id' => optional(auth()->user())->id ?? null,
            'created_at' => now(),
            'updated_at' => null
        ]);

        return $cart;
    }

    public function getCartCookie()
    {
        if (request()->cookie('KOPISLUR-CART-ID')) {
            return $this->generateCartCookie(request()->cookie('KOPISLUR-CART-ID'));
        } else {
            if (auth()->user()) {
                if ($cartId = optional(auth()->user()->cart)->id) {
                    return $this->generateCartCookie($cartId);
                }
            }
            $cart = $this->create();
            return $this->generateCartCookie($cart->id);
        }
    }

    public function generateCartCookie(string $cartId)
    {
        return cookie(
            'KOPISLUR-CART-ID', $cartId, 60*24*30*6
        );
    }
}
