<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


Route::prefix('/auth')->group(function () {
    Route::post('/authenticate', '\App\Http\Controllers\AuthController@authenticate');
    Route::post('/forgot-password-check', '\App\Http\Controllers\AuthController@forgotPasswordCheck');
    Route::post('/reset-password', '\App\Http\Controllers\AuthController@resetPassword');
    Route::post('/update-password', '\App\Http\Controllers\AuthController@updatePassword');
    Route::post('/update-account-settings', '\App\Http\Controllers\AuthController@updateAccountSettings');

    Route::post('/logout', '\App\Http\Controllers\AuthController@logout');
});


Route::prefix('/students')->group(function () {
    Route::post('/store', '\App\Http\Controllers\StudentController@store');
    Route::post('/update', '\App\Http\Controllers\StudentController@update');
    Route::post('/destroy', '\App\Http\Controllers\StudentController@destroy');
    Route::post('/download-pdf', '\App\Http\Controllers\StudentController@downloadPdf');
    Route::post('/download-roll-slips', '\App\Http\Controllers\StudentController@downloadRollSlips');
    Route::post('/download-single-roll-slip', '\App\Http\Controllers\StudentController@downloadSingleRollSlip');
});

