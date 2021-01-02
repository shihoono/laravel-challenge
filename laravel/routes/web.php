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

Route::group(['middleware' => ['admin']], function () {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.get');
    Route::post('register', 'Auth\RegisterController@register')->name('register.post');
    Route::resource('admin', 'AdminController');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'AuctionController@index');
    Route::resource('auction', 'AuctionController');
    Route::get('home2', 'AuctionController@home2')->name('auction.home2');
    Route::get('home', 'AuctionController@home')->name('auction.home');
    Route::get('{id}/bidform', 'AuctionController@bidForm')->name('auction.bidform');
    Route::post('bid', 'AuctionController@bid')->name('auction.bid');
    Route::get('{id}/msg', 'AuctionController@msgForm')->name('auction.msgform');
    Route::post('msg', 'AuctionController@msg')->name('auction.msg');
});
