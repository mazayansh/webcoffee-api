<?php

namespace App\Services;

use App\Interfaces\{
    CartServiceInterface,
    CartRepositoryInterface,
    CartItemRepositoryInterface
};
use Carbon\Carbon;

class CartService implements CartServiceInterface
{
    public function __construct(
        public CartRepositoryInterface $cartRepository,
        public CartItemRepositoryInterface $cartItemRepository
    )
    {

    }

    public function create()
    {
        $cart = $this->cartRepository->save([
            'user_id' => optional(auth()->user())->id ?? null,
            'expired_at' => Carbon::now()->addWeeks(2),
            'created_at' => now(),
            'updated_at' => null
        ]);

        return $cart;
    }

    public function generateCartCookie()
    {
        if (auth()->user()) {
            if ($cartId = optional(auth()->user()->cart)->id) {
                return cookie(
                    config('constants.cookie_name.cart'), 
                    $cartId, 
                    60*24*14
                );
            }
        }

        return cookie(
            config('constants.cookie_name.cart'), 
            $this->create()->id, 
            60*24*14
        );
    }
    
    public function isCartNotEmpty(string $cartId): bool
    {
        if (is_null($cartId)) {
            return false;
        }
        return $this->cartItemRepository->checkIfCartHaveItems($cartId);
    }
}
