<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/

// ROOT
use App\Http\Controllers\Root\RootController;

// CUSTOMER
use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;

// ADMIN AUTH
use App\Http\Controllers\Profile\AdminController;

// ADMIN PANEL
use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\WebSettingController;

/*
|--------------------------------------------------------------------------
| PUBLIC / ROOT ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [RootController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| PACKAGE ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/packages', [RootController::class, 'packageCategories'])
    ->name('packages.categories');

Route::get('/packages/category/{slug}', [RootController::class, 'packageByCategory'])
    ->name('packages.byCategory');

Route::get('/packages/detail/{id}', [RootController::class, 'packageDetail'])
    ->name('packages.detail');

/*
|--------------------------------------------------------------------------
| PORTFOLIO ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/portfolio', [RootController::class, 'portfolio'])
    ->name('portfolio.index');

Route::get('/portfolio/{id}', [RootController::class, 'portfolioDetail'])
    ->name('portfolio.detail');

/*
|--------------------------------------------------------------------------
| CONTACT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/contact', [RootController::class, 'contact'])->name('contact');
Route::post('/contact', [RootController::class, 'contactStore'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| CUSTOMER AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('customer.auth.login');
})->name('customer.login')->middleware('guest');

Route::post('/login', [CustomerAuthController::class, 'login'])
    ->name('customer.login.post')->middleware('guest');

Route::post('/register', [CustomerAuthController::class, 'register'])
    ->name('customer.register')->middleware('guest');

Route::post('/logout', [CustomerAuthController::class, 'logout'])
    ->name('customer.logout')->middleware('auth');
    

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/booking/{package}', [CheckoutController::class, 'checkout'])
        ->name('booking.form');

    Route::post('/booking/store', [CheckoutController::class, 'store'])
        ->name('booking.store');

    Route::get('/payment/{order}', [CustomerPaymentController::class, 'create'])
        ->name('customer.payment.create');

    Route::post('/payment/store', [CustomerPaymentController::class, 'store'])
        ->name('customer.payment.store');

    Route::get('/my-orders', [CustomerController::class, 'history'])
        ->name('customer.orders');

    // PENTING: route delivery HARUS di atas route detail
    // agar /my-orders/5/delivery tidak ditangkap oleh {id}
    Route::get('/my-orders/{orderId}/delivery', [CustomerController::class, 'delivery'])
        ->name('customer.delivery');

    Route::get('/my-orders/{id}', [CustomerController::class, 'detail'])
        ->name('customer.orders.detail');
    
    Route::get('/profile', [CustomerController::class, 'profile'])
        ->name('customer.profile');
 
    Route::put('/profile/update', [CustomerController::class, 'profileUpdate'])
            ->name('customer.profile.update');

    Route::post('/rating',            [\App\Http\Controllers\Customer\CustomerRatingController::class, 'store'])
        ->name('customer.rating.store');

});

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminController::class, 'LoginForm'])
    ->name('admin.login')->middleware('guest');

Route::post('/admin/login', [AdminController::class, 'LoginPost'])
    ->name('admin.login.post')->middleware('guest');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout')->middleware('admin');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware('admin')
    ->group(function () {

        Route::get('/dashboard', [BaseController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/profile', [AdminController::class, 'profile'])
            ->name('admin.profile');

        Route::match(['POST', 'PUT'], '/profile/update', [AdminController::class, 'profileUpdate'])
    ->name('admin.profile.update');

        Route::resource('categories', CategoryController::class);
        Route::post('categories/{id}/toggle', [CategoryController::class, 'toggleStatus'])
    ->name('categories.toggleStatus');
        Route::resource('packages', PackageController::class);
        Route::resource('portfolios', PortfolioController::class);
        Route::resource('orders', AdminOrderController::class);

        Route::post('/orders/{id}/confirm', [AdminOrderController::class, 'confirm'])
            ->name('admin.orders.confirm');
        Route::post('/orders/{id}/complete', [AdminOrderController::class, 'complete'])
            ->name('admin.orders.complete');
        Route::post('/orders/{id}/cancel', [AdminOrderController::class, 'cancel'])
            ->name('admin.orders.cancel');

        Route::resource('payments', PaymentController::class);
        Route::post('/payments/{id}/verify', [PaymentController::class, 'verify'])
            ->name('admin.payments.verify');
        Route::post('/payments/{id}/reject', [PaymentController::class, 'reject'])
            ->name('admin.payments.reject');

        Route::resource('deliveries', DeliveryController::class);
        Route::get('/delivery', [DeliveryController::class, 'index'])
            ->name('admin.delivery.index');


        Route::resource('ratings', RatingController::class);

        Route::get('/websetting', [WebSettingController::class, 'index'])
            ->name('admin.websetting.index');
        Route::post('/websetting', [WebSettingController::class, 'update'])
            ->name('admin.websetting.update');
    });