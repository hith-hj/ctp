<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Main\MainController;
use App\Http\Controllers\Api\Main\ReviewController;
use App\Http\Controllers\Api\Main\SearchController;
use App\Http\Controllers\Api\Order\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\FavoriteProductController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserNotificationController;
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

Route::middleware('lang')->group(function () {

    //AUTH && FCM GROUP
    Route::post('login', [UserController::class, 'login']);
    Route::post('new-user', [UserController::class, 'register']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
    Route::post('forget-password', [UserController::class, 'forgetPassword']);
    Route::post('forget-password-confirm', [UserController::class, 'forgetPasswordConfirm']);
    Route::post('users/activate', [UserController::class, 'activateUser']);

    //CURRENCIES
    Route::get('currencies', [CurrencyController::class, 'index']);

    //PROFILE
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('profile', [UserController::class, 'profilePost']);

    //CATEGORIES
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories-subcategories', [CategoryController::class, 'withSubs']);
    Route::get('category-subcategories/{id}', [CategoryController::class, 'categoryWithSubs']);
    Route::get('category/{id}', [CategoryController::class, 'category']);

    //PRODUCT
    Route::get('products', [ProductController::class, 'index']);
    Route::get('product/{id}', [ProductController::class, 'product']);
    Route::get('my-products', [ProductController::class, 'myProducts']);
    Route::get('modern-products', [ProductController::class, 'modernProduct']);
    Route::get('attributes', [MainController::class, 'attributes']);
    //NOTIFICATIONS
    Route::post('users/firebase/update-token', [UserNotificationController::class, 'updateFirebaseToken']);
    Route::get('users/notifications', [UserNotificationController::class, 'userNotifications']);
    Route::post('users/notifications/change-status', [UserNotificationController::class, 'changeNotificationStatus']);
    Route::get('delete-notification/{id}', [UserNotificationController::class, 'deleteNotification']);
    Route::get('last-notification', [UserNotificationController::class, 'lastNotification']);
    Route::get('mark-notification-read', [UserNotificationController::class, 'readNotification']);
    Route::get('unread-notifications-count', [UserNotificationController::class, 'unreadNotificationsCount']);

    //STORES
    // Route::get('companies', [ProductController::class, 'companies']);
    // Route::get('stores', [AdminController::class, 'index']);
    // Route::get('stores-with-products', [AdminController::class, 'storesWithProducts']);
    // Route::get('store-products/{id}', [AdminController::class, 'storeProducts']);
    // Route::get('store-with-products/{id}', [AdminController::class, 'storeWithProducts']);

    Route::middleware('auth:client')->group(function () {
        //FAVORITE GROUP
        Route::get('favorites', [FavoriteProductController::class, 'getFavorite']);
        Route::post('favorites', [FavoriteProductController::class, 'addToFavorite']);

        //REVIEW
        Route::post('review', [ReviewController::class, 'review']);
        Route::get('reviews', [ReviewController::class, 'reviews']);

        Route::post('checkout', [CartController::class, 'store']);
        Route::get('orders', [OrderController::class, 'index']);
    });

    //GENERAL ENDPOINT
    Route::get('search', [SearchController::class, 'search']);
    Route::get('banners', [HomeController::class, 'banners']);
    Route::get('random-banner', [HomeController::class, 'randomBanners']);
    Route::get('about-us', [HomeController::class, 'about']);
});
