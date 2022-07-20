<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use App\Services\CartService;
use Illuminate\Support\Facades\Cookie;

class ShouldAttachCartCookie
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
        if (! $request->cookie(config('constants.cookie_name.cart'))) {
            $cartService = new CartService(new CartRepository, new CartItemRepository);
            $cartCookie = $cartService->generateCartCookie();
            Cookie::queue($cartCookie);
        }
        return $next($request);
    }
}
