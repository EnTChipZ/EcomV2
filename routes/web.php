<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\RegistrationReviewController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboard;
use App\Http\Controllers\Courier\DashboardController as CourierDashboard;
use App\Http\Controllers\Logistics\CourierReviewController;
use App\Http\Controllers\Logistics\DashboardController as LogisticsDashboard;
use App\Http\Controllers\Seller\DashboardController as SellerDashboard;
use App\Http\Controllers\Shipping\PageController as ShippingPage;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\PageController;
use App\Http\Controllers\Storefront\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:register');
Route::get('/register/seller', [RegisterController::class, 'createSeller'])->name('register.seller');
Route::post('/register/seller', [RegisterController::class, 'storeSeller'])->middleware('throttle:register');
Route::get('/register/rider', [RegisterController::class, 'createRider'])->name('register.rider');
Route::post('/register/rider', [RegisterController::class, 'storeRider'])->middleware('throttle:register');
Route::get('/register/logistics', [RegisterController::class, 'createLogistics'])->name('register.logistics');
Route::post('/register/logistics', [RegisterController::class, 'storeLogistics'])->middleware('throttle:register');
Route::get('/register/pending', [RegisterController::class, 'pending'])->name('register.pending');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{slug}/pay', [ProductController::class, 'pay'])->name('products.pay');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add')->middleware('throttle:60,1');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [PageController::class, 'place'])->name('checkout.place')->middleware('throttle:10,1');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/help', [PageController::class, 'help'])->name('help');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/search', [BuyerDashboard::class, 'search'])->name('search');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::post('/profile', [PageController::class, 'updateProfile'])->name('profile.update')->middleware('throttle:20,1');

    Route::prefix('buyer')->name('buyer.')->group(function () {
        Route::get('/', [BuyerDashboard::class, 'home'])->name('home');
        Route::get('/addresses', [BuyerDashboard::class, 'addresses'])->name('addresses');
        Route::get('/cart', [BuyerDashboard::class, 'cart'])->name('cart');
        Route::get('/checkout', [BuyerDashboard::class, 'checkout'])->name('checkout');
        Route::get('/orders/{order}', [BuyerDashboard::class, 'track'])->name('orders.track');
    });

    Route::middleware('role:seller')->prefix('seller')->name('seller.')->group(function () {
        Route::get('/', [SellerDashboard::class, 'index'])->name('dashboard');
        Route::get('/catalog', [SellerDashboard::class, 'catalog'])->name('catalog');
        Route::get('/orders', [SellerDashboard::class, 'orders'])->name('orders');
        Route::get('/promos', [SellerDashboard::class, 'promos'])->name('promos');
        Route::get('/shipments', [SellerDashboard::class, 'shipments'])->name('shipments');
    });

    Route::middleware('role:courier')->prefix('courier')->name('courier.')->group(function () {
        Route::get('/', [CourierDashboard::class, 'index'])->name('dashboard');
    });

    Route::middleware('role:logistics')->prefix('logistics')->name('logistics.')->group(function () {
        Route::get('/', [LogisticsDashboard::class, 'index'])->name('dashboard');
        Route::get('/couriers', [CourierReviewController::class, 'index'])->name('couriers');
        Route::post('/couriers/{user}', [CourierReviewController::class, 'decide'])
            ->middleware('throttle:30,1')
            ->name('couriers.decide');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/verifications', [RegistrationReviewController::class, 'index'])->name('verifications');
        Route::post('/verifications/{user}', [RegistrationReviewController::class, 'decide'])
            ->middleware('throttle:30,1')
            ->name('verifications.decide');
        Route::get('/cms', [AdminDashboard::class, 'cms'])->name('cms');
        Route::get('/users', [AdminDashboard::class, 'users'])->name('users');
        Route::get('/disputes', [AdminDashboard::class, 'disputes'])->name('disputes');
        Route::get('/reports', [AdminDashboard::class, 'reports'])->name('reports');
    });
});

Route::prefix('shipping')->name('shipping.')->group(function () {
    Route::get('/', [ShippingPage::class, 'home'])->name('home');
    Route::get('/track', [ShippingPage::class, 'track'])->name('track');
    Route::get('/services', [ShippingPage::class, 'services'])->name('services');
    Route::get('/pricing', [ShippingPage::class, 'pricing'])->name('pricing');

    Route::middleware(['auth', 'approved'])->group(function () {
        Route::get('/ship', [ShippingPage::class, 'ship'])->name('ship');
        Route::get('/shipments', [ShippingPage::class, 'shipments'])->name('shipments');
        Route::get('/shipments/{parcel}', [ShippingPage::class, 'details'])->name('details');
        Route::get('/account', [ShippingPage::class, 'account'])->name('account');
    });
});
