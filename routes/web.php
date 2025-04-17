<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SupportController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[SupportController::class, 'dashboard'])->name("dashboard");
});

Route::prefix('/')->name('home.')->group(function () {
    Route::get('about', [HomePageController::class, 'about'])->name('about');
    Route::get('shop', [HomePageController::class, 'shop'])->name('shop');
    Route::get('contact', [HomePageController::class, 'contact'])->name('contact');
    Route::get('cart', [HomePageController::class, 'cart'])->name('cart');
    Route::get('shop-single', [HomePageController::class, 'shopsingle'])->name('shop-single');
});

Route::get('viewcart', [HomePageController::class, 'viewcart'])->name('viewcart');
Route::post('/update', [HomePageController::class, 'updateCart'])->name('cart.update'); // Update cart item
Route::post('removecart', [HomePageController::class, 'removeFromCart'])->name('cart.remove');
Route::get('category-single', [HomePageController::class, 'shopByCategory'])->name('shop.category');
Route::get('/checkout', [HomePageController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [HomePageController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order', [HomePageController::class, 'order'])->name('order.process');

Route::get('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout.post');
//Route::post('/stripe/checkout/process', [StripeController::class, 'processPayment'])->name('stripe.process');
Route::get('/stripe/checkout/success', [StripeController::class, 'handleSuccess'])->name('stripe.checkout.success');

Route::prefix('/')->name('admin.')->group(function () {
    Route::get('/update', [AdminController::class, 'update'])->name('update');
    Route::get('/view', [AdminController::class, 'view'])->name('view');
});

Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
