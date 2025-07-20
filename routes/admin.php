<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminExtraController;
use App\Http\Controllers\Admin\AttributeExtraController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SettingExtraController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

// GENERAL & AUTOCOMPLETE ROUTES
Route::get('/', [HomeController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/search', [SearchController::class, 'search'])
    ->name('search');
//Route::get('/change-lang/{locale}', [HomeController::class,'changeLanguage'])->name('change-lang');

Route::get('/changeLanguage.{local}', [HomeController::class, 'changeLanguage'])
    ->name('changeLanguage');

Route::get('/attributesAutoComplete', [AttributeExtraController::class, 'attributesAutoComplete'])
    ->name('attributesAutoComplete');

Route::get('/getCategoryAttributes', [AttributeExtraController::class, 'getCategoryAttributes'])
    ->name('getCategoryAttributes');

Route::get('/VendorsAutoComplete', [AdminExtraController::class, 'VendorsAutoComplete'])
    ->name('VendorsAutoComplete');

Route::get('/usersAutoComplete', [UserController::class, 'usersAutoComplete'])
    ->name('usersAutoComplete');

Route::get('/productsAutoComplete', [ProductController::class, 'productsAutoComplete'])
    ->name('productsAutoComplete');

Route::get('/banners/getModels', [BannerController::class, 'getModels'])
    ->name('banners.getModels');

Route::get('remove-images', [ProductController::class, 'removeImage'])->name('removeImage');
Route::get('request', [RequestController::class, 'index'])->name('requests.request');

//SETTING GROUP
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/about-us', [SettingExtraController::class, 'about'])->name('about');
    Route::get('/contact-us', [SettingExtraController::class, 'contact'])->name('contact');
    Route::get('/terms-conditions', [SettingExtraController::class, 'terms'])->name('terms');
    Route::get('/privacy-policy', [SettingExtraController::class, 'privacy'])->name('privacy');
    Route::get('/contact-us', [SettingExtraController::class, 'contact'])->name('contact');
    Route::get('/admin-name', [SettingExtraController::class, 'adminName'])->name('adminName');
    Route::get('/admin-email', [SettingExtraController::class, 'adminEmail'])->name('adminEmail');
});

Route::prefix('datatables')->name('datatables.')->group(function () {
    Route::POST('/getAdmins', [AdminController::class, 'getAdmins'])
        ->name('getAdmins');
    Route::POST('/getUsers', [UserController::class, 'getUsers'])
        ->name('getUsers');
    Route::POST('/getProducts', [ProductController::class, 'getProducts'])
        ->name('getProducts');
    Route::POST('/getInventoryItems', [InventoryController::class, 'getInventoryItems'])
        ->name('getInventoryItems');
    // Route::POST('/getServices',[ServiceController::class, 'getServices'])
    //     ->name('getServices');
    Route::GET('/setStatus/{order}', [AdminController::class, 'setStatus'])
        ->name('setStatus');
    // Route::POST('/getBookings',[BookingController::class, 'getBookings'])
    //     ->name('getBookings');
});

//ORDERS GROUP
Route::prefix('orders')->name('orders.')->group(function () {
    Route::POST('/getOrders', [OrderController::class, 'getOrders'])
        ->name('getOrders');
    Route::GET('/', [OrderController::class, 'index'])
        ->name('index');
    Route::get('/byStatus/{status}', [OrderStatusController::class, 'index'])
        ->name('byStatus');
    Route::post('/byStatus/{status}', [OrderStatusController::class, 'byStatus'])
        ->name('byStatus');
    Route::GET('/{order}', [OrderController::class, 'show'])
        ->name('show');
    Route::GET('/setOrderStatus/{order}', [OrderController::class, 'setOrderStatus'])
        ->name('setOrderStatus');
});

// REPORTS GROUP
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/date-wise-sales', [ReportController::class, 'dateWiseSalesIndex'])
        ->name('dateWiseSalesIndex');
    Route::get('/sales-details', [ReportController::class, 'salesDetailsIndex'])
        ->name('salesDetailsIndex');
    Route::get('/item-wise-sales', [ReportController::class, 'itemWiseSalesIndex'])
        ->name('itemWiseSalesIndex');
    Route::get('/area-wise-sales', [ReportController::class, 'areaWiseSalesIndex'])
        ->name('areaWiseSalesIndex');
    Route::get('/country-wise-sales', [ReportController::class, 'countryWiseSalesIndex'])
        ->name('countryWiseSalesIndex');
    Route::get('generate-pdf', [ReportController::class, 'generatePDF'])
        ->name('generatePDF');
    Route::get('export-csv', [ReportController::class, 'exportCSV'])
        ->name('exportCSV');
});

// RESOURCES
Route::resource('admins', '\App\Http\Controllers\Admin\AdminController');
Route::resource('users', '\App\Http\Controllers\Admin\UserController');
Route::resource('banners', '\App\Http\Controllers\Admin\BannerController')->except('show');
Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
Route::resource('categories', '\App\Http\Controllers\Admin\CategoryController');
Route::resource('attributes', '\App\Http\Controllers\Admin\AttributeController');
Route::resource('products', '\App\Http\Controllers\Admin\ProductController');
// Route::resource('services', '\App\Http\Controllers\Admin\ServiceController');
Route::resource('settings', '\App\Http\Controllers\Admin\SettingController');
Route::resource('requests', '\App\Http\Controllers\Admin\RequestController');
// Route::resource('bookings', '\App\Http\Controllers\Admin\BookingController');
Route::resource('notifications', '\App\Http\Controllers\Admin\NotificationController');
Route::resource('orders', '\App\Http\Controllers\Admin\OrderController');
// Route::resource('countries', '\App\Http\Controllers\Admin\CountryController');
Route::resource('cities', '\App\Http\Controllers\Admin\CityController');
Route::resource('sliders', '\App\Http\Controllers\Admin\SliderController');
Route::resource('currencies', '\App\Http\Controllers\Admin\CurrencyController');
Route::resource('coupons', '\App\Http\Controllers\Admin\CouponController');

// Admin new Setting
Route::get('adminSetting', [SettingController::class, 'getAdminSetting'])->name('getAdminSetting');
Route::post('addAdminSetting', [SettingController::class, 'addAdminSetting'])->name('addAdminSetting');
Route::post('editAdminSetting/{id}', [SettingController::class, 'editAdminSetting'])->name('editAdminSetting');
Route::get('deleteAdminSetting/{id}', [SettingController::class, 'deleteAdminSetting'])->name('deleteAdminSetting');

Route::post('productPriceRanges/{product}', [ProductController::class, 'productPriceRanges'])->name('productPriceRanges');
Route::post('deleteProductPriceRange/{range_id}', [ProductController::class, 'deleteProductPriceRange'])->name('deleteProductPriceRange');
// Route::get('adminSetting',[SettingController::class,'getAdminSetting']);

Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::post('addInventoryItemQuantity/{id}', [InventoryController::class, 'addInventoryItemQuantity'])->name('addInventoryItemQuantity');
Route::post('deleteInventoryItem/{id}', [InventoryController::class, 'deleteInventoryItem'])->name('deleteInventoryItem');
Route::post('deleteCategoryImage/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteCategoryImage'])->name('deleteCategoryImage');
Route::get('changePassword', [\App\Http\Controllers\Admin\AdminController::class, 'changePasswordForm'])->name('changePasswordForm');
Route::post('changePassword', [\App\Http\Controllers\Admin\AdminController::class, 'changePassword'])->name('changePassword');

Route::get('offers', [OfferController::class, 'index'])->name('offers.index');
Route::get('create', [OfferController::class, 'create'])->name('createOffer');
Route::post('storeOffer', [OfferController::class, 'storeOffer'])->name('storeOffer');
Route::post('updateOffer/{id}', [OfferController::class, 'updateOffer'])->name('updateOffer');
Route::post('deleteOffer/{id}', [OfferController::class, 'deleteOffer'])->name('deleteOffer');
