<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingsPrivacyController as AdminSettingsPrivacyController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PublicFormController;
use App\Http\Controllers\Frontend\ShopController;
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
    Route::get('/product', [ShopController::class, 'product'])->name('frontend.product');
    Route::post('/reviews', [ShopController::class, 'storeReview'])->name('frontend.reviews.store');
    Route::view('/contact', 'frontend.contactus')->name('frontend.contact');
    Route::post('/newsletter', [PublicFormController::class, 'newsletter'])->name('frontend.newsletter.subscribe');
    Route::post('/contact', [PublicFormController::class, 'contact'])->name('frontend.contact.submit');
    Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('frontend.cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('frontend.cart.clear');
    Route::view('/empty-cart', 'frontend.empty-cart')->name('frontend.empty-cart');
    Route::match(['get', 'post'], '/shipping', [CheckoutController::class, 'shippingInfo'])->name('frontend.shipping');
    Route::match(['get', 'post'], '/checkout-shipping', [CheckoutController::class, 'shippingMethod'])->name('frontend.checkout-shipping');
    Route::match(['get', 'post'], '/payment', [CheckoutController::class, 'payment'])->name('frontend.payment');
    Route::match(['get', 'post'], '/checkout-place-order', [CheckoutController::class, 'place'])->name('frontend.checkout.place');
    Route::post('/payment/stripe/intent', [CheckoutController::class, 'createStripeIntent'])->name('frontend.payment.stripe.intent');
    Route::get('/payment/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('frontend.payment.stripe.success');
    Route::get('/payment/stripe/cancel', [CheckoutController::class, 'stripeCancel'])->name('frontend.payment.stripe.cancel');
    Route::get('/payment/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('frontend.payment.paypal.success');
    Route::get('/payment/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('frontend.payment.paypal.cancel');
});

Route::get('/dashboard', fn () => redirect('/admin'))->name('admin.dashboard.legacy');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}/main-image', [AdminProductController::class, 'removeMainImage'])->name('products.main-image.delete');
    Route::delete('/products/{product}/gallery/{image}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.gallery.delete');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::get('/subscribers', [AdminNewsletterController::class, 'index'])->name('subscribers.index');
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [AdminNotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings-privacy', [AdminSettingsPrivacyController::class, 'show'])->name('settings.privacy.show');
    Route::post('/settings-privacy', [AdminSettingsPrivacyController::class, 'update'])->name('settings.privacy.update');
});

