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

Route::view('/dashboard', 'admin-backend.index')->name('admin.dashboard');
Route::view('/dashboard/pages-profile', 'admin-backend.pages-profile')->name('admin.profile');
Route::view('/dashboard/pages-sign-in', 'admin-backend.pages-sign-in')->name('admin.sign-in');
Route::view('/dashboard/pages-sign-up', 'admin-backend.pages-sign-up')->name('admin.sign-up');
Route::view('/dashboard/pages-blank', 'admin-backend.pages-blank')->name('admin.blank');
Route::view('/dashboard/ui-buttons', 'admin-backend.ui-buttons')->name('admin.ui.buttons');
Route::view('/dashboard/ui-forms', 'admin-backend.ui-forms')->name('admin.ui.forms');
Route::view('/dashboard/ui-cards', 'admin-backend.ui-cards')->name('admin.ui.cards');
Route::view('/dashboard/ui-typography', 'admin-backend.ui-typography')->name('admin.ui.typography');
Route::view('/dashboard/icons-feather', 'admin-backend.icons-feather')->name('admin.icons.feather');
Route::view('/dashboard/charts-chartjs', 'admin-backend.charts-chartjs')->name('admin.charts.chartjs');
Route::view('/dashboard/maps-google', 'admin-backend.maps-google')->name('admin.maps.google');
Route::view('/dashboard/upgrade-to-pro', 'admin-backend.upgrade-to-pro')->name('admin.upgrade');

