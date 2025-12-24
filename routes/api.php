<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('/dashboard')->group(function () {
    Route::post('/pie-chart', '\App\Http\Controllers\DashboardController@pieChart');
    Route::post('/line-chart', '\App\Http\Controllers\DashboardController@lineChart');
});

Route::prefix('/auth')->group(function () {
    Route::post('/authenticate', '\App\Http\Controllers\AuthController@authenticate');
    Route::post('/forgot-password-check', '\App\Http\Controllers\AuthController@forgotPasswordCheck');
    Route::post('/reset-password', '\App\Http\Controllers\AuthController@resetPassword');
    Route::post('/update-password', '\App\Http\Controllers\AuthController@updatePassword');
    Route::post('/update-account-settings', '\App\Http\Controllers\AuthController@updateAccountSettings');

    Route::post('/logout', '\App\Http\Controllers\AuthController@logout');
});

Route::prefix('/users')->group(function () {
    Route::post('/store', '\App\Http\Controllers\UserController@store');
    Route::post('/update', '\App\Http\Controllers\UserController@update');
    Route::post('/delete', '\App\Http\Controllers\UserController@destroy');
});

Route::prefix('/schools')->group(function () {
    Route::post('/store', '\App\Http\Controllers\SchoolController@store');
    Route::post('/update', '\App\Http\Controllers\SchoolController@update');
    Route::post('/destroy', '\App\Http\Controllers\SchoolController@destroy');
    Route::get('/check-screenshot', '\App\Http\Controllers\SchoolController@checkScreenshot');
    Route::post('/store-screenshot', '\App\Http\Controllers\SchoolController@storeScreenshot');
    Route::post('/download-pdf', '\App\Http\Controllers\SchoolController@downloadPdf');
});

Route::prefix('/students')->group(function () {
    Route::post('/store', '\App\Http\Controllers\StudentController@store');
    Route::post('/store-individual', '\App\Http\Controllers\StudentController@storeIndividual');
    Route::post('/update', '\App\Http\Controllers\StudentController@update');
    Route::post('/destroy', '\App\Http\Controllers\StudentController@destroy');
    Route::post('/download-pdf', '\App\Http\Controllers\StudentController@downloadPdf');
    Route::post('/download-roll-slips', '\App\Http\Controllers\StudentController@downloadRollSlips');
    Route::post('/download-roll-slip-individual', '\App\Http\Controllers\StudentController@downloadRollSlipIndividual');
    Route::post('/download-roll-slip', '\App\Http\Controllers\StudentController@downloadRollSlip');
    Route::post('/download-single-roll-slip', '\App\Http\Controllers\StudentController@downloadSingleRollSlip');
});

Route::prefix('/participant')->group(function () {
    
    Route::post('/delete', '\App\Http\Controllers\SchoolController@destroyParticipant');
    
});
