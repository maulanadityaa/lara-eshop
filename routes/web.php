<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'Frontend\FrontendController@index')->name('home');
Route::get('/category', 'Frontend\FrontendController@category');
Route::get('/view-category/{slug}', 'Frontend\FrontendController@viewcategory');
Route::get('/view-category/{cate_slug}/{prod_slug}', 'Frontend\FrontendController@viewproduct');
Route::get('/get-product-name', 'Frontend\FrontendController@getProductName');
Route::post('/search-product', 'Frontend\FrontendController@searchProduct');
Route::get('/all-products', 'Frontend\FrontendController@allProducts');


Auth::routes();

Route::get('/home', 'Frontend\FrontendController@index');

Route::post('add-to-cart', 'Frontend\CartController@addProduct');
Route::post('delete-cart-item', 'Frontend\CartController@deleteProduct');
Route::post('update-cart', 'Frontend\CartController@updateCart');

Route::post('add-to-wishlist', 'Frontend\WishlistController@add');
Route::post('delete-wishlist-item', 'Frontend\WishlistController@deleteItem');

Route::middleware(['auth'])->group(function () {
    Route::get('user-profile', 'Frontend\UserController@viewProfile');
    Route::get('user-profile/edit-profile', 'Frontend\UserController@editProfile');
    Route::post('user-profile/edit-profile/update', 'Frontend\UserController@updateProfile');

    Route::get('cart', 'Frontend\CartController@viewCart');
    Route::post('cart/change-note', 'Frontend\CartController@changeNote');

    Route::get('wishlist', 'Frontend\WishlistController@index');

    Route::get('checkout', 'Frontend\CheckoutController@index');
    Route::post('checkout/place-order', 'Frontend\CheckoutController@placeOrder');
    Route::get('checkout/place-order/paynow/{id}', 'Frontend\CheckoutController@payNow');

    Route::post('checkout/place-order/paynow/submit-payment', 'Frontend\MidtransController@submitPayment');
    Route::get('/view-order/update-status/{id}', 'Frontend\MidtransController@updateStatus');

    Route::get('cek-ongkir/cities/{province_id}', 'Frontend\CheckoutController@getCities');
    Route::post('cek-ongkir/', 'Frontend\CheckoutController@cekOngkir');

    Route::get('my-orders', 'Frontend\OrderController@index');
    Route::get('view-order/{id}', 'Frontend\OrderController@view');
    Route::get('view-order/print-invoice/{id}', 'Frontend\OrderController@printPDF');
    Route::get('view-order/cancel-order/{id}', 'Frontend\OrderController@cancelOrder');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', 'Admin\FrontendController@index');

    Route::get('categories', 'Admin\CategoryController@index');
    Route::get('categories/check-slug', 'Admin\CategoryController@checkSlug');
    Route::get('add-categories', 'Admin\CategoryController@add');
    Route::post('insert-category', 'Admin\CategoryController@insert');
    Route::get('edit-category/{id}', 'Admin\CategoryController@edit');
    Route::put('update-category/{id}', 'Admin\CategoryController@update');
    Route::get('delete-category/{id}', 'Admin\CategoryController@destroy');

    Route::get('products', 'Admin\ProductController@index');
    Route::get('products/check-slug', 'Admin\ProductController@checkSlug');
    Route::get('add-products', 'Admin\ProductController@add');
    Route::post('insert-products', 'Admin\ProductController@insert');
    Route::get('edit-product/{id}', 'Admin\ProductController@edit');
    Route::put('update-product/{id}', 'Admin\ProductController@update');
    Route::get('delete-product/{id}', 'Admin\ProductController@destroy');

    Route::get('users', 'Admin\FrontendController@users');

    Route::get('admin/orders', 'Admin\OrderController@index');
    Route::get('admin/confirm-order/{id}', 'Admin\OrderController@confirmOrder');
    Route::get('admin/decline-order/{id}', 'Admin\OrderController@declineOrder');
    Route::get('admin/order-history', 'Admin\OrderController@orderHistory');
    Route::post('admin/order-history/print-report', 'Admin\OrderController@printReport');
    Route::get('admin/view-order-details/{id}', 'Admin\OrderController@view');
    Route::put('admin/update-order/{id}', 'Admin\OrderController@updateOrder');
});
