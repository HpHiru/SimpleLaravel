<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLoginStatus;


Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/import-products', [MainController::class, 'import'])->name('import-products');
Route::post('/sendotp', [\App\Http\Controllers\Auth\LoginController::class, 'sendEmailOtp'])->name('sendotp');
Route::post('/loginCheck', [\App\Http\Controllers\Auth\LoginController::class, 'loginCheck'])->name('loginCheck');

Route::get('/add-data', [MainController::class, 'addDummyData'])->name('add-data')->middleware(CheckLoginStatus::class);;

Route::get('/home', function () {
    return view('add-dummy-data');
})->name('home')->middleware(CheckLoginStatus::class);
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware(CheckLoginStatus::class);;