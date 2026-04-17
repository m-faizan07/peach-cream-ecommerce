<?php

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

Route::view('/', 'frontend.index')->name('frontend.home');
Route::view('/about', 'frontend.About')->name('frontend.about');
Route::view('/product', 'frontend.Product-page')->name('frontend.product');
Route::view('/contact', 'frontend.contactus')->name('frontend.contact');
Route::view('/cart', 'frontend.cart')->name('frontend.cart');
Route::view('/empty-cart', 'frontend.empty-cart')->name('frontend.empty-cart');
Route::view('/shipping', 'frontend.shipping')->name('frontend.shipping');
Route::view('/checkout-shipping', 'frontend.checkout-shipping')->name('frontend.checkout-shipping');
Route::view('/payment', 'frontend.payment')->name('frontend.payment');

// Route::redirect('/frontend/index.html', '/');
// Route::redirect('/frontend/About.html', '/about');
// Route::redirect('/frontend/Product-page.html', '/product');
// Route::redirect('/frontend/contactus.html', '/contact');
// Route::redirect('/frontend/cart.html', '/cart');
// Route::redirect('/frontend/empty-cart.html', '/empty-cart');
// Route::redirect('/frontend/shipping.html', '/shipping');
// Route::redirect('/frontend/checkout-shipping.html', '/checkout-shipping');
// Route::redirect('/frontend/payment.html', '/payment');
