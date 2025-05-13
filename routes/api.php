<?php

use Illuminate\Support\Facades\Route;
use Jazer\Multimedia\Http\Controllers\SignIn\EmailPassword;

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'multimedia'], function () {
        Route::get('test', function () {
            echo "Tested";
        });
    });
});

