<?php

Auth::routes();

Route::resource('/video', 'VideoController', ['only' => ['show']]);


Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('channel/{slug}', 'VideoController@channel')->name('channel.index');

Route::get('/redirect-to-facebook', 'SocialAuthController@redirect')->name('login.facebook');
Route::get('/callback-facebook', 'SocialAuthController@callback');


Route::get('/video/{id}/download', 'VideoController@download')->name('video.download');
Route::get('/view/{hash}', 'VideoController@generatedVideoByHash')->name('view');
Route::get('/my-videos/{slug}', 'VideoController@generatedVideo')->name('my-video');

Route::post('/share/email', 'ShareController@email')->name('share.email');


Route::post('/paypal/process', 'PayPalWebhooksController@processPayment');



Route::group(['middleware' => 'auth'], function () {
    Route::post('/video/generate', 'VideoController@generate');
    Route::get('/my-videos', 'VideoController@generatedVideos')->name('my-videos');


    Route::get('/subscription', 'SubscriptionController@index')->name('subscription.index');
    Route::post('/subscription', 'SubscriptionController@store');
    Route::delete('/subscription', 'SubscriptionController@cancel');

    Route::get('/subscription/success', 'SubscriptionController@paypalSuccess');
    Route::get('/subscription/error', 'SubscriptionController@paypalError');


    Route::group(['prefix' => 'admin','middleware' => 'admin','as' => 'admin.'], function () {
        Route::get('/', 'Admin\AdminController@index')->name('index');

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

        Route::post('/playlist/change-order', 'Admin\PlaylistController@changeOrder')->name('playlist.change-order');
        Route::resource('/playlist', 'Admin\PlaylistController', ['only' => [
            'create', 'store', 'destroy'
        ]]);

        Route::get('/user/{id}/videos', 'Admin\UserController@videos')->name('user.videos');
        Route::get('/user/login/{id}',  'Admin\UserController@login')->name('user.login');
        Route::get('/user/search', 'Admin\UserController@search')->name('user.search');
        Route::get('/user/data', 'Admin\UserController@data')->name('user.data');

        Route::resource('/user', 'Admin\UserController');

        Route::get('/plan/index', 'Admin\PlanController@index')->name('plan.index');
        Route::post('/plan/update/{id}', 'Admin\PlanController@update')->name('plan.update');
    });
});

