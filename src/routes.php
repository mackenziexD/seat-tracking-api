<?php

Route::group([ 
    'namespace' => 'Helious\SeatTrackingAPI\Http\Controllers\Api',
    'prefix' => 'api',
    'middleware' => ['api.request', 'api.auth'],
], function () {
    
    Route::group(['namespace' => 'v2', 'prefix' => 'v2'], function () {
        Route::group(['prefix' => 'tracking'], function () {
            Route::get('/afk')->uses('TrackingController@afk');
        });
    });

});