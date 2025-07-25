<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

// Route::get('/register', [RegisteredUserController::class, 'create'])
//                 ->middleware('guest')
//                 ->name('register');

// Route::post('/register', [RegisteredUserController::class, 'store'])
//                 ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::group(['as' => 'user.', 'middleware' => ['lang'], 'namespace' => 'User'], function () {

    Route::get('user/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::get('user/logout', [LoginController::class, 'logout'])
        ->middleware('auth:user')
        ->name('logout');

    Route::post('user/register', [RegisterController::class, 'register'])
        ->name('register.post');

    Route::get('/user/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/user/login', [LoginController::class, 'login'])
        ->name('login.post');

    Route::get('/verification', [RegisterController::class, 'verification'])
        ->name('verification');

    Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])
        ->name('resendVerification');

    Route::post('/verification-code', [RegisterController::class, 'activeUser'])
        ->name('verification.code');

    Route::get('/forget-password', [RegisterController::class, 'forgetPassword'])
        ->name('forget-password');

    Route::get('/get-code', [RegisterController::class, 'getCodePage'])
        ->name('get-code');

    Route::post('user/reset/password', [RegisterController::class, 'checkCode'])
        ->name('reset-password');

    Route::post('/reset/password/', [RegisterController::class, 'sendCode'])
        ->name('send-code');

    Route::get('/email/verify', function () {
        if (session()->has('user')) {
            return view('website.auth.verify-code');
        } else {
            return redirect()->route('user.login');
        }
    })->name('verification.notice');

    Route::post('/email/verify', [RegisterController::class, 'verificationCode'])->name('verification.code');
    Route::post('/email/verify/resend-code', [RegisterController::class, 'resendVerificationCode'])->name('verification.resendcode');

    // Route::get('/email/verify',function(){
    //     return view('website.auth.verify-email');
    // })->name('verification.notice');

    // Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    //     $request->fulfill();
    //     return redirect()->route('user.index');
    // })->middleware(['auth', 'signed'])->name('verification.verify');

    // Route::post('/email/verification-notification', function (Request $request) {
    //     $request->user()->sendEmailVerificationNotification();
    //     return back()->with('message', 'Verification link sent!');
    // })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

});
