<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
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

Route::middleware('no_admin_frontend')->group(function () {
    Route::view('/', 'frontend.index')->name('frontend.home');
    Route::view('/about', 'frontend.About')->name('frontend.about');
    Route::view('/product', 'frontend.Product-page')->name('frontend.product');
    Route::view('/contact', 'frontend.contactus')->name('frontend.contact');
    Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('frontend.cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('frontend.cart.clear');
    Route::view('/empty-cart', 'frontend.empty-cart')->name('frontend.empty-cart');
    Route::match(['get', 'post'], '/shipping', [CheckoutController::class, 'shippingInfo'])->name('frontend.shipping');
    Route::match(['get', 'post'], '/checkout-shipping', [CheckoutController::class, 'shippingMethod'])->name('frontend.checkout-shipping');
    Route::match(['get', 'post'], '/payment', [CheckoutController::class, 'payment'])->name('frontend.payment');
    Route::match(['get', 'post'], '/checkout-place-order', [CheckoutController::class, 'place'])->name('frontend.checkout.place');
});

Route::get('/dashboard', fn () => redirect('/admin'))->name('admin.dashboard.legacy');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::get('/subscribers', [AdminNewsletterController::class, 'index'])->name('subscribers.index');
});

