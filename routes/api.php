<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'cart'
], function ($router) {
    Route::post('/addProduct', [App\Http\Controllers\CartController::class, 'addProduct']);
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'order'
], function ($router) {
    Route::post('/cancel', [App\Http\Controllers\OrderController::class, 'cancel']);
    Route::post('/pay', [App\Http\Controllers\OrderController::class, 'pay']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product'
], function ($router) {
    Route::get('/list', [App\Http\Controllers\ProductController::class, 'getProductList']);
});