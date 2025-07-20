<?php

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CurrencyController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth:web', 'lang']], function () {
    require_once base_path('routes/admin.php');
});
Route::group(['as' => 'user.', 'namespace' => 'User'], function () {
    require_once base_path('routes/user.php');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
Route::get('/change-lang', [HomeController::class, 'changeLang'])->name('change-lang');

Route::get('/changeCurrency/{code?}', [CurrencyController::class, 'changeCurrency'])
    ->name('changeCurrency')->middleware('lang');

Route::group(['middleware' => ['auth:user', 'lang', 'currency']], function () {
    Route::put('/cart/{id}', [CartController::class, 'postUpdate']);
    Route::get('/cart', [CartController::class, 'getIndex'])->name('cart');
    Route::post('/add-to-cart', [CartController::class, 'postAdd']);
    Route::post('/add-to-cart-web', [CartController::class, 'AddToCart'])->name('AddToCart');
    Route::post('/update-cart', [CartController::class, 'postUpdateAll'])->name('updateCart');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/proceed-checkout', [CartController::class, 'proceedToCheckout'])->name('proceedToCheckout');
    Route::post('/createShippingDetailsFromUser', [CartController::class, 'createShippingDetailsFromUser'])->name('createShippingDetailsFromUser');

    Route::group(['controller' => PaymentController::class, 'prefix' => 'payment'], function () {
        Route::get('/paymentSuccess', 'paymentSuccess')->name('payment.success');
        Route::get('/paymentFaild/{msg?}', 'paymentFaild')->name('payment.faild');
        Route::get('/{id}/{type?}', 'payment')->name('payment.item');
        Route::get('/checkout/{id}/{type}', 'checkout')->name('payment.checkout.item');
        Route::post('/purchase/{id}/{type}', 'purchase')->name('payment.purchase');
        Route::get('/userInvoices', 'getUserInvoices')->name('payment.userInvoices');
    });

});

Route::view('/privacy', 'privacy');
Route::view('/faqs', 'faqs')->name('faqs');
Route::view('/support', 'support');
