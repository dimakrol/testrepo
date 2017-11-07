<?php

Auth::routes();

Route::post('/video/generate', 'VideoController@generate');
Route::resource('/video', 'VideoController', ['only' => ['show']]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('channel/{slug}', 'VideoController@channel')->name('channel.index');

Route::get('/redirect-to-facebook', 'SocialAuthController@redirect')->name('login.facebook');
Route::get('/callback-facebook', 'SocialAuthController@callback');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/subscription', 'SubscriptionController@index')->name('subscription.index');
    Route::post('/subscription', 'SubscriptionController@store');
    Route::delete('/subscription', 'SubscriptionController@cancel');

    Route::group(['prefix' => 'admin','as' => 'admin.'], function () {
        Route::view('/', 'admin.index')->name('index');

        Route::get('/user/{id}/videos', 'Admin\UserController@videos')->name('user.videos');
        Route::resource('/video', 'Admin\VideoController');
        Route::resource('/category', 'Admin\CategoryController', ['only' => [
            'create', 'store', 'destroy'
        ]]);
        Route::resource('/tag', 'Admin\TagController', ['only' => [
            'create', 'store', 'destroy'
        ]]);
        Route::resource('/field', 'Admin\FieldController', ['only' => [
            'create', 'store', 'destroy'
        ]]);
    });
});

