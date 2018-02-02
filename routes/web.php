<?php

Auth::routes();


Route::resource('/video', 'VideoController', ['only' => ['show']]);

//Route::get('/sitemap.xml', 'SitemapController@index');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('channel/{slug}', 'VideoController@channel')->name('channel.index');

Route::get('/redirect-to-facebook', 'SocialAuthController@redirect')->name('login.facebook');
Route::get('/callback-facebook', 'SocialAuthController@callback');


Route::get('/video/{id}/download', 'VideoController@download')->name('video.download');

Route::get('view/make-preview', 'VideoController@makePreview')->name('view.make-preview');
Route::get('/view/{hash}', 'VideoController@generatedVideoByHash')->name('view');

Route::get('/category/{slug}', 'CategoryController@show')->name('category.show');

Route::post('/share/email', 'ShareController@email')->name('share.email');

Route::post('/paypal/process', 'PayPalWebhooksController@processPayment');



Route::group(['middleware' => 'auth'], function () {
    Route::post('/video/generate', 'VideoController@generate');
    Route::get('/my-videos', 'VideoController@generatedVideos')->name('my-videos');


    Route::get('/subscription', 'SubscriptionController@index')->name('subscription.index');
    Route::post('/subscription', 'SubscriptionController@store')->name('subscription.store');
    Route::delete('/subscription', 'SubscriptionController@cancel');

    Route::get('/subscription/success', 'SubscriptionController@paypalSuccess');
    Route::get('/subscription/error', 'SubscriptionController@paypalError');

    Route::get('/account', 'UserController@index')->name('account');
    Route::get('/add-facebook/{id}', 'UserController@addFacebook')->name('add-facebook');
    Route::get('/connect-facebook', 'UserController@connectFacebook')->name('connect-facebook');
    Route::get('/disconnect-facebook/{id}', 'UserController@disconnectFacebook')->name('disconnectFacebook');
    Route::post('/user/{id}/update', 'UserController@update')->name('user.update');
    Route::post('/user/delete/{id}', 'UserController@delete')->name('user.delete');

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

        Route::post('/playlist/{id}/display','Admin\PlaylistController@changeDisplay')->name('playlist.display');
        Route::post('/playlist/{id}/link','Admin\PlaylistController@changeLink')->name('playlist.link');
        Route::post('/playlist/change-order', 'Admin\PlaylistController@changeOrder')->name('playlist.change-order');
        Route::get('/playlist/{id}/videos', 'Admin\PlaylistController@changeOrderOfVideos')->name('playlist.change-video-order');
        Route::post('/playlist/{id}/videos', 'Admin\PlaylistController@updateOrderOfVideos')->name('playlist.update-video-order');
        Route::resource('/playlist', 'Admin\PlaylistController', ['only' => [
            'create', 'store', 'destroy'
        ]]);

        Route::get('/subscription/data', 'Admin\SubscriptionController@data')->name('subscription.data');
        Route::get('/subscription/add-free/{id}','Admin\SubscriptionController@addFreeSubscription')->name('subscription.add-free');
        Route::resource('/subscription', 'Admin\SubscriptionController', ['only' => ['index', 'destroy']]);

        Route::get('/user/{id}/videos', 'Admin\UserController@videos')->name('user.videos');
        Route::get('/user/login/{id}',  'Admin\UserController@login')->name('user.login');
        Route::get('/user/data', 'Admin\UserController@data')->name('user.data');

        Route::resource('/user', 'Admin\UserController');

        Route::post('/plan/dot', 'Admin\PlanController@changeDot')->name('plan.dot');
        Route::get('/plan/index', 'Admin\PlanController@index')->name('plan.index');
        Route::post('/plan/update/{id}', 'Admin\PlanController@update')->name('plan.update');
    });
});

