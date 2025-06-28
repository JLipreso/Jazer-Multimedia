<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'multimedia'], function () {
        Route::group(['prefix' => 'general'], function () {
            
        });
        Route::group(['prefix' => 'document'], function () {
            Route::get('upload', function () {});
            Route::get('delete', function () {});
            Route::get('rename', function () {});
            Route::get('fetchpaginate', function () {});
            Route::get('fetchsingle', function () {});
        });
        Route::group(['prefix' => 'photo'], function () {
            Route::post('upload', [Jazer\Multimedia\Http\Controllers\Upload\Photo::class, 'upload']);
            Route::get('delete', function () {});
            Route::get('rename', function () {});
            Route::get('fetchpaginate', [Jazer\Multimedia\Http\Controllers\Fetch\Paginate::class, 'paginate']);
            Route::get('fetchsingle', function () {});
        });
        Route::group(['prefix' => 'video'], function () {
            Route::get('upload', function () {});
            Route::get('delete', function () {});
            Route::get('rename', function () {});
            Route::get('fetchpaginate', function () {});
            Route::get('fetchsingle', function () {});
        });
    });
});

