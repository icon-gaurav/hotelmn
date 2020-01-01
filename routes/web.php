<?php

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

Route::get('/', 'HomeController@index');

Route::get('/rooms', 'HomeController@allRooms');
Route::get('/rooms/{id}', 'HomeController@getRoom');
Route::post('/checkout','HomeController@checkout');
Route::get('/payment_response','HomeController@checkpayment');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified', 'is_admin']], function () {
    Route::resource('/customers', 'CustomerController');

    Route::resource('/rooms', 'RoomController');

    Route::resource('/bookings','BookingController');

    Route::resource('/images','ImageController');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified', 'is_emp']], function () {
    Route::get('/bookings', 'BookingController@index');
});

Auth::routes(['verify' => true]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
