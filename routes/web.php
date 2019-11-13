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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::stripeWebhooks('stripe/charge/succeeded');


// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    
    Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');
    Route::get('/subscription/cancel/{plan}', 'SubscriptionController@cancel')->name('subscription.cancel');

    Route::get('/items', 'ItemController@index')->name('items.index');
    Route::get('/item/{item}', 'ItemController@show')->name('items.show');
    Route::post('/item/buy', 'ItemController@buy')->name('items.buy');
});