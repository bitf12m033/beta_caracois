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
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/ajax/products', 'ProductController@fetchAllProducts')->name('ajax-products');
Route::get('/ajax/users', 'UserController@fetchAllUsers')->name('ajax-users');

/*Route::resource('products', 'ProductController');
Route::resource('users', 'UserController');*/
Route::resources([
    'products' => 'ProductController',
    'users' => 'UserController',
   
]);