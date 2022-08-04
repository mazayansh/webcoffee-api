<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    Roast\RoastController,
    Type\TypeController,
    Product\ProductController,
    Cart\CartController,
    Cart\CartItemController,
    Cart\CheckoutController,
    Cart\ShippingController,
    Cart\ShippingInfoController,
    Order\OrderController,
    Order\OrderPaymentController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // User auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::middleware(['api'])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
        });
        Route::get('/user-profile', [AuthController::class, 'userProfile']);
    });
    // Roasts level
    Route::get('/roasts', [RoastController::class, 'index']);
    // Coffee types
    Route::get('/types', [TypeController::class, 'index']);
    // Product
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    // Cart
    Route::prefix('/cart')->group(function () {
        Route::put('/cart-items/{cart_item_id}', [CartItemController::class, 'update']);
        Route::delete('/cart-items/{cart_item_id}', [CartItemController::class, 'destroy']);
        Route::middleware(['cart_cookie.exists'])->group(function () {
            Route::get('/', [CartController::class, 'show']);
            Route::post('/cart-items', [CartItemController::class, 'store']);
            Route::get('/shipping-info', ShippingInfoController::class);
            Route::middleware(['cart.not_empty'])->group(function () {
                Route::post('/checkout', CheckoutController::class);
                Route::post('/shipping', ShippingController::class);
            });
        });
    });
    Route::prefix('/orders')->group(function () {
        Route::post('/', [OrderController::class, 'store'])->middleware(['cart_cookie.exists','cart.not_empty']);
        Route::post('/payment/notification/handling', [OrderPaymentController::class, 'handleNotification']);
    });
});
