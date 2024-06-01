<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Merchant\SettingController;
use App\Http\Controllers\Merchant\StoreContentController;
use App\Http\Controllers\Merchant\StoreSetupController;

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

Route::group(['prefix' => 'merchant', 'middleware' => 'merchant', 'as' => 'merchant.'], function () {

    // Store Setup
    Route::get('/store-setup/welcome', [StoreSetupController::class, 'welcome'])->name('storeSetup');
    Route::get('/store-setup/en', [StoreSetupController::class, 'stepsEn'])->name('stepsEn');
    Route::get('/store-setup/bn', [StoreSetupController::class, 'stepsBn'])->name('stepsBn');
    Route::get('/store-setup/picture', [StoreSetupController::class, 'pictureForm'])->name('pictureForm');
    Route::post('/store-setup/picture', [StoreSetupController::class, 'picture'])->name('picture');
    Route::get('/store-setup/category', [StoreSetupController::class, 'categoryForm'])->name('categoryForm');
    Route::post('/store-setup/category', [StoreSetupController::class, 'category'])->name('category');
    Route::get('/store-setup/external-links', [StoreSetupController::class, 'externalLinksForm'])->name('externalLinksForm');
    Route::post('/store-setup/external-links', [StoreSetupController::class, 'externalLinks'])->name('externalLinks');
    Route::get('/store-setup/filter', [StoreSetupController::class, 'filterForm'])->name('filterForm');
    Route::post('/store-setup/filter', [StoreSetupController::class, 'filter'])->name('filter');

    Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
    Route::get('/store-setting', [SettingController::class, 'storeSettingForm'])->name('storeSettingForm');
    Route::post('/store-setting', [SettingController::class, 'storeSetting'])->name('storeSetting');

    Route::get('/store-opening-hours', [SettingController::class, 'storeOpeningHoursForm'])->name('storeOpeningHoursForm');
    Route::post('/store-opening-hours', [SettingController::class, 'storeOpeningHours'])->name('storeOpeningHours');

    Route::post('/get-subcategories', [SettingController::class, 'getSubcategories'])->name('getSubcategories');

    Route::get('/store-opening-hours', [SettingController::class, 'storeOpeningHoursForm'])->name('storeOpeningHoursForm');
    Route::post('/store-opening-hours', [SettingController::class, 'storeOpeningHours'])->name('storeOpeningHours');

    Route::get('/store-gallery-setting', [SettingController::class, 'gallerySettingForm'])->name('gallerySettingForm');
    Route::post('/store-gallery-setting', [SettingController::class, 'gallerySetting'])->name('gallerySetting');

    Route::delete('/remove-gallery-item/{id}', [SettingController::class, 'galleryItemRemove'])->name('galleryItemRemove');

    Route::get('/account-setting', [SettingController::class, 'accountSettingForm'])->name('accountSettingForm');
    Route::post('/account-setting', [SettingController::class, 'accountSetting'])->name('accountSetting');

    Route::get('/add-content', [StoreContentController::class, 'storeContentForm'])->name('storeContentForm');
    Route::post('/store-post', [StoreContentController::class, 'storePost'])->name('storePost');
    Route::post('/store-offer', [StoreContentController::class, 'storeOffer'])->name('storeOffer');
    Route::post('/store-billboard', [StoreContentController::class, 'storeBillboard'])->name('storeBillboard');

    Route::post('/get-slots', [StoreContentController::class, 'getSlots'])->name('getSlots');
    Route::post('/store-highlight', [StoreContentController::class, 'storeHighlight'])->name('storeHighlight');
    Route::post('/store-content-update', [StoreContentController::class, 'updateContent'])->name('updateContent');

    Route::delete('/delete-content', [StoreContentController::class, 'deleteContent'])->name('deleteContent');
});
