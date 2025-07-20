<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['lang', 'currency'])->group(function () {
    Route::get('/vendors', [HomeController::class, 'getVendors'])->name('vendors');
    Route::get('/become-vendor', [UserController::class, 'becomeVendor'])->name('become-vendor');
    Route::post('/become-vendor', [UserController::class, 'storeUserDetail'])->name('store-request-user');

    // GENERAL & AUTOCOMPLETE ROUTES
    Route::get('/', [HomeController::class, 'index'])
        ->name('index');
    Route::get('/about', [HomeController::class, 'about'])
        ->name('about');
    Route::get('/contact', [HomeController::class, 'contact'])
        ->name('contact');
    Route::get('/categories', [HomeController::class, 'categories'])
        ->name('categories');

    Route::post('/contact', [HomeController::class, 'contactUs'])
        ->name('contactUs');
    // RESOURCES
    Route::get('/filterProducts', [ProductController::class, 'getProducts'])->name('filterProducts');
    Route::get('/filter_products', [ProductController::class, 'filterShopProducts'])->name('filterShopProducts');

    Route::resource('products', '\App\Http\Controllers\User\ProductController');

    Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function () {
        Route::get('/account/{option?}', [UserController::class, 'index'])->name('user-account');
        Route::put('/update-account/{user}', [UserController::class, 'update'])->name('user-update');
        Route::post('/update-shipping-details', [UserController::class, 'shippingAddress'])->name('shipping-address');
    });

    //CART
    Route::group(['middleware' => 'auth:user'], function () {
        Route::get('/fetchData', [CartController::class, 'fetchData'])->name('fetchData');
        Route::get('/cart', [CartController::class, 'getIndex'])->name('cart');
        Route::get('/order', [CartController::class, 'getOrders'])->name('order');
        Route::get('/order/{code?}', [CartController::class, 'showOrder'])->name('order.show');
        Route::post('/remove-products', [CartController::class, 'removeProduct'])->name('remove-products');
        Route::post('/update', [CartController::class, 'update'])->name('update-cart');
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
        Route::get('/add-wishlist/{product?}', [WishlistController::class, 'store'])->name('add-wishlist');
        Route::get('/check-coupon/{code?}', [CouponController::class, 'couponCheck'])->name('check-coupon');

    });
    //Product
    Route::get('/product/{slug}', [ProductController::class, 'getProductsByCategory'])->name('product-category');
    Route::get('/products/{slug}/category', [ProductController::class, 'getProductsByMainCategory'])->name('product-main-category');
    Route::get('/product/details/{id?}', [ProductController::class, 'getProductDetails'])->name('get-product-details');
});
