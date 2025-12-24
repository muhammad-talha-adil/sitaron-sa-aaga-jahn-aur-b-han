<?php

use App\Http\Controllers\SchoolController;
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


Route::prefix('/default')->group(function () {
    Route::get('/create', function () {
        return view('default.create');
    });

    Route::get('/list', function () {
        return view('default.list');
    });
});

Route::middleware('CheckUser')->group(function () {
    //Route::get('/dashboard', '\App\Http\Controllers\DashboardController@index');
    Route::get('/dashboard', '\App\Http\Controllers\SchoolController@create');
    Route::post('/logout', '\App\Http\Controllers\AuthController@logout');

    Route::prefix('/users')->group(function () {
        Route::get('/', '\App\Http\Controllers\UserController@index');
        Route::get('/create', '\App\Http\Controllers\UserController@create');
        Route::post('/create', '\App\Http\Controllers\UserController@store');
        Route::get('/{id}/edit', '\App\Http\Controllers\UserController@edit');
        Route::post('/{id}/edit', '\App\Http\Controllers\UserController@update');
        Route::post('/{id}/delete', '\App\Http\Controllers\UserController@destroy');
    });

    Route::prefix('/schools')->group(function () {
        Route::get('/', '\App\Http\Controllers\SchoolController@index');
        Route::get('/create', '\App\Http\Controllers\SchoolController@create');
        Route::post('/create', '\App\Http\Controllers\SchoolController@store');
        Route::get('/{id}/edit', '\App\Http\Controllers\SchoolController@edit');
        Route::post('/{id}/edit', '\App\Http\Controllers\SchoolController@update');
        Route::post('/{id}/delete', '\App\Http\Controllers\SchoolController@destroy');
        Route::get('/payment-proofs', '\App\Http\Controllers\SchoolController@paymentProofs');
        Route::get('/check-screenshot', '\App\Http\Controllers\SchoolController@checkScreenshot');
        Route::post('/store-screenshot', '\App\Http\Controllers\SchoolController@storeScreenshot');
        Route::post('/download-pdf', '\App\Http\Controllers\SchoolController@downloadPdf');
    });

    Route::prefix('/students')->group(function () {
        Route::get('/', '\App\Http\Controllers\StudentController@index');
        Route::get('/create', '\App\Http\Controllers\StudentController@create');
        Route::get('/create-individual', '\App\Http\Controllers\StudentController@createIndividual');
        Route::post('/create', '\App\Http\Controllers\StudentController@store');
        Route::post('/create-individual', '\App\Http\Controllers\StudentController@storeIndividual');
        Route::get('/{id}/edit', '\App\Http\Controllers\StudentController@edit');
        Route::get('/{id}/edit-individual', '\App\Http\Controllers\StudentController@editIndividual');
        Route::post('/{id}/edit', '\App\Http\Controllers\StudentController@update');
        Route::post('/{id}/delete', '\App\Http\Controllers\StudentController@destroy');
        Route::post('/download-pdf', '\App\Http\Controllers\StudentController@downloadPdf');
        Route::post('/download-roll-slips', '\App\Http\Controllers\StudentController@downloadRollSlips');
    });
});


