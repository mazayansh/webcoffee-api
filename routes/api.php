<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    Roast\RoastController,
    Type\TypeController,
    Product\ProductController,
    Cart\CartController,
    Cart\CartItemController
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
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::middleware(['cart_cookie.exists'])->group(function () {
        Route::prefix('/cart')->group(function () {
            Route::get('/', [CartController::class, 'show']);
            Route::post('/checkout', [CartController::class, 'checkout']);
            Route::post('/cart-items', [CartItemController::class, 'store']);
            Route::put('/cart-items/{cart_item_id}', [CartItemController::class, 'update']);
            Route::delete('/cart-items/{cart_item_id}', [CartItemController::class, 'destroy']);
        });
    });
});
