<?php

use Illuminate\Support\Facades\Route;

//Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\VerifyController;

Route::group(['prefix' => 'auth', 'middleware' => 'guest', 'as' => 'auth.'], function () {
    Route::get('/login', [LoginController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::post('check-email', [SignUpController::class, 'checkEmailAvailability'])->name('checkEmailAvailability');
    Route::post('check-phone', [SignUpController::class, 'checkPhoneAvailability'])->name('checkPhoneAvailability');

    Route::get('/signup', [SignUpController::class, 'signUpForm'])->name('signUpForm');
    Route::post('/signup-user', [SignUpController::class, 'signUpUser'])->name('signUpUser');
    Route::post('/signup-merchant', [SignUpController::class, 'signUpMerchant'])->name('signUpMerchant');
});

Route::get('/verify-account/{token}', [VerifyController::class, 'verifyAccount'])->middleware('auth')->name('auth.verifyAccount');
Route::get('/resend-verification-email', [VerifyController::class, 'resendVerificationEmail'])->middleware('auth')->name('auth.resendVerificationEmail');

Route::get('auth/logout', [LoginController::class, 'logout'])->middleware('auth')->name('auth.logout');
