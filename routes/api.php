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
Route::apiResource('/Shop', ShopController::class);
// Prefix of a specific shop
Route::group(['prefix'=>'/Shop'], function () {

    //Registring to a shop Routes
    Route::post('{shop}/register', [AuthController::class, 'register'])->name('register');
    Route::post('{shop}/login', [AuthController::class, 'login'])->name('login');
    Route::post('{shop}/Admin', [AuthController::class, 'Adminlogin'])->name('Adminlogin');

    //Route::apiResource('/Products', ProductController::class);
    Route::get('{shop}/Products', [ProductController::class,'index'])->name('Products.index');
    Route::get('{shop}/Products/{id}', [ProductController::class,'show'])->name('Products.show');
    Route::get('{shop}/products/search/{name}', [ProductController::class, 'search']);
    Route::post('{shop}/Products', [ProductController::class,'store'])->name('Products.store');
    Route::put('{shop}/Products/{id}', [ProductController::class,'update'])->name('Products.update');
    Route::delete('{shop}/Products/{id}', [ProductController::class,'destroy'])->name('Products.destroy');

    // Product categories
    Route::apiResource('{shop}/Category', CategoriesController::class);

    //Logout from a shop
    Route::middleware('auth:sanctum')->post('{shop}/logout', [AuthController::class, 'logout']);

    // ORder Routes :
    Route::middleware('auth:sanctum')->apiResource('{shop}/Orders', OrderController::class);
});
    //Specific Product Reviews
    Route::group(['prefix'=>'/Products'], function () {
        Route::apiResource('/{product}/Reviews', ReviewController::class);
    }) ;

// create new shop
Route::post('/newShop', [ShopController::class,'newStore'])->name('Shop.newStore');

// Extern Product Routes (Woocommerce,shopify...)

Route::apiResource('/externProduct', ExternPoductController::class);

/// Cart Routes
 Route::group(['prefix'=>'/Shop'], function () {
     Route::get('{shop}/cart', [CartController::class,'index']);
     Route::post('{shop}/cart/{id}', [CartController::class,'add']);
     Route::delete('{shop}/cart/{id}', [CartController::class,'delete']);
 });

// User Route
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
