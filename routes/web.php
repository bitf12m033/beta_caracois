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
    // Artisan::call('migrate');
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
        'orders' => 'OrderController',
    ]);
});

Route::group(['middleware'=> 'auth'], function()
{
    Route::resources([
        'customerorder' => 'CustomerOrder',
    ]);
    Route::patch('update-cart', 'ProductController@update_cart');
    Route::delete('remove-from-cart', 'ProductController@remove_cart');
    Route::get('product-ajax', 'ProductController@productAjax');
    Route::get('add-to-cart/{id}', 'ProductController@addToCart');
    Route::get('cart', 'ProductController@cart')->name('order.cart');
    Route::post('change_status', 'OrderController@change_status')->name('orders.change_status');
    Route::post('orders_update/{id}', 'OrderController@orders_update')->name('orders_update');
    Route::get('order_product-ajax', 'ProductController@order_products')->name('all_order_product');
    Route::get('changepassword', 'UserController@changepassword')->name('changepassword');
    Route::post('updatepassword', 'UserController@updatepassword')->name('password.update');
});
Route::get('/send/email', function () {
    $mail_data['name'] = 'test';
    $mail_data['subject'] = 'Account Created';
    $mail_data['order_no'] = '323';
    $mail_data['contact_no'] = '03126000109';
    $mail_data['total'] = '220';
    $name = 'b013.049@gmail.com';
    \Illuminate\Support\Facades\Mail::to($name)->send(new \App\Mail\OrderPlaced($mail_data));

    return 'Email sent Successfully';
});


