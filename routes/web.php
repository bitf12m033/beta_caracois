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
    return view('front.index');
    // return view('auth.login');
});
Route::get('/contact-us', function () {
    return view('front.contact');
});

Route::get('/about-us', function () {
    return view('front.about');
});
Route::get('/bo', function () {
    return view('auth.login');
});

Route::get('/home-login', function () {
    return view('front.auth.login');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('user');

Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/products-list', 'HomeController@showProducts')->name('products-list');
Route::post('/atc', 'CustomerProductController@addToCartAjax')->name('addtocart');
Route::post('/update-atc', 'CustomerProductController@updateCart')->name('updatecart');
Route::get('/cart-detail', 'CustomerProductController@getCartDetails')->name('cartdetail');
Route::get('/checkout', 'CustomerProductController@checkout')->name('checkout');
Route::post('/place-order', 'CustomerProductController@placeOrder')->name('placeorder');

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function()
{
    Route::get('/ajax/products', 'ProductController@fetchAllProducts')->name('ajax-products');
    Route::get('/ajax/users', 'UserController@fetchAllUsers')->name('ajax-users');
    Route::get('delivery-persons', 'UserController@delivery_boys')->name('delivery-persons');
    Route::get('all-customers', 'UserController@all_customers')->name('all-customers');
    /*Route::resource('products', 'ProductController');
    Route::resource('users', 'UserController');*/
    Route::resources([
        'products' => 'ProductController',
        'users' => 'UserController',
        'orders' => 'OrderController',
    ]);
});

Route::group(['middleware' => 'App\Http\Middleware\DeliveryBoyMiddleware'], function()
{
    Route::get('delivery-orders', 'OrderController@index')->name('delivery-orders');
});

Route::group(['middleware'=> 'auth'], function()
{
    Route::resources([
        'customerorder' => 'CustomerOrder',
        'customer-products' => 'CustomerProductController',
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

    Route::get('customer-cart', 'CustomerProductController@cart')->name('customer.order.cart');
    Route::get('user-profile/{id}', 'ShowProfile');

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


