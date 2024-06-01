<?php

use Illuminate\Support\Facades\Route;

// User
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\LikeController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\SavedOfferController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'account', 'middleware' => 'user', 'as' => 'user.'], function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/follow-store', [DashboardController::class, 'followStore'])->name('followStore');
    Route::post('/save-offer', [DashboardController::class, 'saveOffer'])->name('saveOffer');
    Route::post('/like', [DashboardController::class, 'likeContent'])->name('likeContent');
    Route::post('/submit-comment', [DashboardController::class, 'submitComment'])->name('submitComment');
    Route::post('/edit-comment', [DashboardController::class, 'editComment'])->name('editComment'); 
    Route::post('/delete-comment', [DashboardController::class, 'deleteComment'])->name('deleteComment');

    Route::get('/setting', [SettingController::class, 'settingForm'])->name('settingForm');
    Route::post('/setting', [SettingController::class, 'updateSetting'])->name('updateSetting');
});