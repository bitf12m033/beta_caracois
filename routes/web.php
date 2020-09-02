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
Route::get('/clear', function() {
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::get('/ajax/products', 'ProductController@fetchAllProducts')->name('ajax-products');
    Route::get('/ajax/users', 'UserController@fetchAllUsers')->name('ajax-users');
    Route::get('user-profile/{id}', 'ShowProfile');
    /*Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');*/
    Route::resources([
        'products' => 'ProductController',
        'users' => 'UserController',
    ]);
    Route::patch('update-cart', 'ProductController@update_cart');
    Route::delete('remove-from-cart', 'ProductController@remove_cart');
    Route::get('product-ajax', 'ProductController@productAjax');
    Route::get('add-to-cart/{id}', 'ProductController@addToCart');
    Route::get('cart', 'ProductController@cart')->name('order.cart');
});

Route::group(['middleware'=> 'auth'], function()
{
    Route::resources([
        'orders' => 'OrderController',
    ]);

    Route::post('change_status', 'OrderController@change_status')->name('orders.change_status');
    Route::get('order_product-ajax', 'ProductController@order_products')->name('all_order_product');
});



