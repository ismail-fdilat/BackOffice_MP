<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExternPoductController;
use App\Http\Controllers\ProductImagesController;

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
// Products and registring apis

//Shop Routes
Route::apiResource('/shop', ShopController::class);
// Prefix of a specific shop
Route::group(['prefix'=>'/shop'], function () {

    //Registring to a shop Routes
    Route::post('{shop}/register', [AuthController::class, 'register'])->name('register');
    Route::post('{shop}/login', [AuthController::class, 'login'])->name('login');
    Route::post('{shop}/admin', [AuthController::class, 'Adminlogin'])->name('Adminlogin');

    //Route::apiResource('/Products', ProductController::class);
    Route::get('{shop}/products', [ProductController::class,'index'])->name('Products.index');
    Route::get('{shop}/products/{id}', [ProductController::class,'show'])->name('Products.show');
    Route::get('{shop}/products/search/{name}', [ProductController::class, 'search']);
    Route::post('{shop}/products', [ProductController::class,'store'])->name('Products.store');
    Route::put('{shop}/products/{id}', [ProductController::class,'update'])->name('Products.update');
    Route::delete('{shop}/products/{id}', [ProductController::class,'destroy'])->name('Products.destroy');

    // Product categories
    Route::middleware('cors')->apiResource('{shop}/category', CategoriesController::class);

    //Logout from a shop
    Route::middleware('auth:sanctum')->post('{shop}/logout', [AuthController::class, 'logout']);

    // ORder Routes :
    Route::apiResource('{shop}/orders', OrderController::class);
});
    //Specific Product Reviews
    Route::group(['prefix'=>'/products'], function () {
        Route::apiResource('/{product}/reviews', ReviewController::class);
        Route::apiResource('/{product}/images', ProductImagesController::class);
    }) ;

// create new shop
Route::post('/newShop', [ShopController::class,'newStore'])->name('Shop.newStore');

// Extern Product Routes (Woocommerce,shopify...)

Route::apiResource('/externProduct', ExternPoductController::class);

/// Cart Routes
 Route::group(['prefix'=>'/shop'], function () {
     Route::get('{shop}/cart', [CartController::class,'index']);
     Route::post('{shop}/cart/{id}', [CartController::class,'add']);
     Route::delete('{shop}/cart/{id}', [CartController::class,'delete']);
 });

// User Route
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
