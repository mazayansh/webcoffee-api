<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use App\Services\CartService;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\CookieHelper;

class CartMustNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cartId = request()->cookie(config('constants.cookie_name.cart'))
                    ?? 
                    CookieHelper::getCookieValueFromQueue(config('constants.cookie_name.cart'));
        $cartService = new CartService(new CartRepository, new CartItemRepository);
        $isCartNotEmpty = $cartService->isCartNotEmpty($cartId);
        
        if ($isCartNotEmpty) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Your cart is empty. Please add our special coffee product to your cart first.'
        ], 400);
    }
}
