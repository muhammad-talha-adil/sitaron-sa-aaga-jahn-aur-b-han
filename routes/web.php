<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB Routes
|--------------------------------------------------------------------------
*/
Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    echo "Hurray! Cache, Config, View Are cleared";
});

Route::fallback('\App\Http\Controllers\HomeController@show404');

Route::get('/', '\App\Http\Controllers\AuthController@login');
Route::get('/login', '\App\Http\Controllers\AuthController@login');
Route::get('/rebuild', '\App\Http\Controllers\StudentController@rebuildRollNumbers');

Route::prefix('/auth')->group(function () {
    Route::get('/', '\App\Http\Controllers\AuthController@login');
    Route::get('/login', '\App\Http\Controllers\AuthController@login');
    Route::get('/forgot-password', '\App\Http\Controllers\AuthController@forgotPassword');
    Route::get('/reset/{reset_password_token}', '\App\Http\Controllers\AuthController@reset');
    Route::get('/change-password', '\App\Http\Controllers\AuthController@changePassword');
    Route::get('/account-settings', '\App\Http\Controllers\AuthController@accountSettings');
});



Route::middleware('CheckUser')->group(function () {
    Route::get('/dashboard', '\App\Http\Controllers\StudentController@index');
    Route::post('/logout', '\App\Http\Controllers\AuthController@logout');


    Route::prefix('/students')->group(function () {
        Route::get('/', '\App\Http\Controllers\StudentController@index');
        Route::get('/create', '\App\Http\Controllers\StudentController@create');
        Route::post('/create', '\App\Http\Controllers\StudentController@store');
        Route::get('/{id}/edit', '\App\Http\Controllers\StudentController@edit');
        Route::post('/{id}/edit', '\App\Http\Controllers\StudentController@update');
        Route::post('/{id}/delete', '\App\Http\Controllers\StudentController@destroy');
        Route::post('/download-single-roll-slip', '\App\Http\Controllers\StudentController@downloadSingleRollSlip');
    });
});


