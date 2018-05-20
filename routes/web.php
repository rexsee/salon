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

Route::get('/', 'IndexController@index')->name('index');
Route::post('processing', 'IndexController@processing')->name('processing')->middleware('throttle:20,1');
Route::get('news/{date}/{slug}', 'IndexController@news')->name('news');
Route::get('booking', 'IndexController@booking')->name('booking');

Route::group(['prefix' => 'staff-panel', 'as'=>'staff'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('.login');
        Route::post('/', 'Auth\LoginController@login')->name('.login');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::match(['get','post'],'home', 'Staff\IndexController@home')->name('.home');
        Route::post('logout', 'Auth\LoginController@logout')->name('.logout');

        //Stylists
        Route::group(['prefix' => 'stylist', 'as'=>'.stylist'], function () {
            Route::get('', 'Staff\StylistController@index');
            Route::match(['get','post'],'add', 'Staff\StylistController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\StylistController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\StylistController@delete')->name('.delete');
        });

        //News
        Route::group(['prefix' => 'news', 'as'=>'.news'], function () {
            Route::get('', 'Staff\NewsController@index');
            Route::match(['get','post'],'add', 'Staff\NewsController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\NewsController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\NewsController@delete')->name('.delete');
        });

        //Services
        Route::group(['prefix' => 'service', 'as'=>'.service'], function () {
            Route::get('', 'Staff\ServiceController@index');
            Route::match(['get','post'],'add', 'Staff\ServiceController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\ServiceController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\ServiceController@delete')->name('.delete');
        });

        //Booking
        Route::group(['prefix' => 'booking', 'as'=>'.booking'], function () {
            Route::get('', 'Staff\BookingController@index');
            Route::match(['get','post'],'add', 'Staff\BookingController@add')->name('.add');
            Route::match(['get','post'],'update/{id}', 'Staff\BookingController@update')->name('.update');
        });

        //Calender
        Route::group(['prefix' => 'calender', 'as'=>'.calender'], function () {
            Route::get('', 'Staff\CalenderController@index');
        });

        //Customer
        Route::group(['prefix' => 'customer', 'as'=>'.customer'], function () {
            Route::get('', 'Staff\CustomerController@index');
            Route::match(['get','post'],'add', 'Staff\CustomerController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\CustomerController@edit')->name('.edit');
            Route::get('detail/{id}', 'Staff\CustomerController@detail')->name('.detail');
            Route::match(['get','post'],'activity/{id}', 'Staff\CustomerController@activity')->name('.activity');
            Route::match(['get','post'],'sms-burst', 'Staff\CustomerController@sms')->name('.sms_burst');
        });

        //Gallery
        Route::group(['prefix' => 'gallery', 'as'=>'.gallery'], function () {
            Route::get('', 'Staff\GalleryController@index');
            Route::match(['get','post'],'add', 'Staff\GalleryController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\GalleryController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\GalleryController@delete')->name('.delete');
        });
    });
});

//Auth::routes();