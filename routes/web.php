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

Route::view('/', 'index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('user', function() {
        return Auth::user()->with('subscriptions')->first();
    });

    Route::get('/subscription', 'SubscriptionController@index')->name('subscription.index');
    Route::post('/subscription', 'SubscriptionController@store');
    Route::delete('/subscription', 'SubscriptionController@cancel');

    Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
        Route::view('/', 'admin.index')->name('index');

        Route::resource('/video', 'Admin\VideoController');
        Route::resource('/category', 'Admin\CategoryController', ['only' => [
            'create', 'store', 'destroy'
        ]]);

        Route::resource('/field', 'Admin\FieldController', ['only' => [
            'create', 'store', 'destroy'
        ]]);
    });
});

