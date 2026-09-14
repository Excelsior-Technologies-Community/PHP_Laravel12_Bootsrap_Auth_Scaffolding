<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginActivityController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');


    /*
    |--------------------------------------------------------------------------
    | Profile Management
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


/*
|--------------------------------------------------------------------------
| Change Password
|--------------------------------------------------------------------------
*/

Route::get('/password', [PasswordController::class, 'edit'])
    ->name('password.edit');

Route::post('/password', [PasswordController::class, 'update'])
    ->name('password.change');


    /*
    |--------------------------------------------------------------------------
    | Login Activity
    |--------------------------------------------------------------------------
    */

    Route::get('/login-activities', [LoginActivityController::class, 'index'])
        ->name('login.activities');

});