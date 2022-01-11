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


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('add-to-cart', 'Frontend\CartController@addProduct');
Route::post('delete-cart-item', 'Frontend\CartController@deleteProduct');
Route::post('update-cart', 'Frontend\CartController@updateCart');

Route::middleware(['auth'])->group(function () {
    Route::get('cart', 'Frontend\CartController@viewCart');
    Route::get('checkout', 'Frontend\CheckoutController@index');
    
    Route::get('cek-ongkir/cities/{province_id}', 'Frontend\CheckoutController@getCities');
    Route::post('cek-ongkir/', 'Frontend\CheckoutController@cekOngkir');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', 'Admin\FrontendController@index');

    Route::get('categories', 'Admin\CategoryController@index');
    Route::get('add-categories', 'Admin\CategoryController@add');
    Route::post('insert-category', 'Admin\CategoryController@insert');
    Route::get('edit-category/{id}', 'Admin\CategoryController@edit');
    Route::put('update-category/{id}', 'Admin\CategoryController@update');
    Route::get('delete-category/{id}', 'Admin\CategoryController@destroy');

    Route::get('products', 'Admin\ProductController@index');
    Route::get('add-products', 'Admin\ProductController@add');
    Route::post('insert-products', 'Admin\ProductController@insert');
    Route::get('edit-product/{id}', 'Admin\ProductController@edit');
    Route::put('update-product/{id}', 'Admin\ProductController@update');
    Route::get('delete-product/{id}', 'Admin\ProductController@destroy');
});
