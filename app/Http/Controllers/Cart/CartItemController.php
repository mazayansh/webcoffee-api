<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    AddCartItemRequest,
    UpdateCartItemRequest
};
use App\Interfaces\{
    CartServiceInterface,
    CartItemServiceInterface
};
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    public function __construct(
        public CartServiceInterface $cartService,
        public CartItemServiceInterface $cartItemService
    )
    {

    }

    public function store(AddCartItemRequest $request)
    {
        $cartCookie = $this->cartService->getCartCookie();
        $cartId = $cartCookie->getValue();
        $newCartItem = $this->cartItemService
                            ->addToCart(
                                $cartId, 
                                $request->validated()
                            );

        return response()->json([
                            'created' => true,
                            'message' => 'Cart item successfully added',
                            'cart_item' => new CartItemResource($newCartItem)
                        ], 201)
                        ->withCookie($cartCookie);
    }

    public function update(UpdateCartItemRequest $request, $cartItemId)
    {
        $isUpdateCartItemSuccess = $this->cartItemService
                                ->updateCartItem(
                                    $cartItemId, 
                                    $request->validated()
                                );
        
        if (! $isUpdateCartItemSuccess) {
            return response()->json([
                'updated' => false,
                "message" => "Cart item not found or can't be updated"
            ], 404);
        }
        
        return response()->json([
                'updated' => true,
                "message" => 'Cart item successfully updated'
            ], 200);
    }

    public function destroy($cartItemId)
    {
        $isRemoveCartItemSuccess = $this->cartItemService
                                        ->removeFromCart($cartItemId);
        if (! $isRemoveCartItemSuccess) {
            return response()->json([
                'deleted' => false,
                "message" => "Cart item not found or can't be removed"
            ], 404);
        }

        return response()->json([
            'deleted' => true,
            "message" => "Cart item successfully removed"
        ], 200);
    }
}
