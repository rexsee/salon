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
Route::post('product-detail', 'IndexController@productDetail')->name('productDetail');
Route::match(['get','post'],'new', 'IndexController@newCustomerAuth')->name('newCustomerAuth');
Route::match(['get','post'],'new-customer', 'IndexController@newCustomer')->name('newCustomer');
Route::get('thank-you', 'IndexController@thankYou')->name('thankYou');
Route::get('booking', 'IndexController@booking')->name('booking');

Route::group(['prefix' => 'staff-panel', 'as'=>'staff'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('.login');
        Route::post('/', 'Auth\LoginController@login')->name('.login');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::match(['get','post'],'home', 'Staff\IndexController@home')->name('.home');
        Route::match(['get','post'],'profile', 'Staff\IndexController@profile')->name('.profile');
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
            Route::get('follow-up', 'Staff\CustomerController@followUp')->name('.follow_up');
            Route::get('follow-up-update/{id}', 'Staff\CustomerController@followUpUpdate')->name('.follow_up_update');
            Route::get('export', 'Staff\CustomerController@export')->name('.export');
            Route::get('export-log/{id}', 'Staff\CustomerController@exportCustomerLog')->name('.export_log');
            Route::match(['get','post'],'add', 'Staff\CustomerController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\CustomerController@edit')->name('.edit');
            Route::get('detail/{id}', 'Staff\CustomerController@detail')->name('.detail');
            Route::get('delete/{id}', 'Staff\CustomerController@deleteCustomer')->name('.delete');
            Route::match(['get','post'],'edit-log/{id}', 'Staff\CustomerController@editLog')->name('.edit_log');
            Route::match(['get','post'],'delete-log/{id}', 'Staff\CustomerController@deleteLog')->name('.delete_log');
            Route::match(['get','post'],'add-log/{customer_id}', 'Staff\CustomerController@addLog')->name('.add_log');
            Route::match(['get','post'],'sms-blast', 'Staff\CustomerController@sms')->name('.sms_blast');
            Route::get('sms-delete/{id}', 'Staff\CustomerController@deleteSms')->name('.sms_delete');
        });

        //Gallery
        Route::group(['prefix' => 'gallery', 'as'=>'.gallery'], function () {
            Route::get('', 'Staff\GalleryController@index');
            Route::match(['get','post'],'add', 'Staff\GalleryController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\GalleryController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\GalleryController@delete')->name('.delete');
        });

        //About Photos
        Route::group(['prefix' => 'about-img', 'as'=>'.about_img'], function () {
            Route::get('', 'Staff\AboutImgController@index');
            Route::match(['get','post'],'add', 'Staff\AboutImgController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\AboutImgController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\AboutImgController@delete')->name('.delete');
        });

        //Vision Photos
        Route::group(['prefix' => 'vision-img', 'as'=>'.vision_img'], function () {
            Route::get('', 'Staff\VisionImgController@index');
            Route::match(['get','post'],'add', 'Staff\VisionImgController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\VisionImgController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\VisionImgController@delete')->name('.delete');
        });

        //Artwork Photos
        Route::group(['prefix' => 'artwork', 'as'=>'.artwork'], function () {
            Route::get('', 'Staff\ArtworkController@index');
            Route::match(['get','post'],'add', 'Staff\ArtworkController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\ArtworkController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\ArtworkController@delete')->name('.delete');
        });

        //Product
        Route::group(['prefix' => 'product', 'as'=>'.product'], function () {
            Route::get('', 'Staff\ProductController@index');
            Route::match(['get','post'],'add', 'Staff\ProductController@add')->name('.add');
            Route::match(['get','post'],'edit/{id}', 'Staff\ProductController@edit')->name('.edit');
            Route::get('delete/{id}', 'Staff\ProductController@delete')->name('.delete');
        });
    });
});

//Auth::routes();
