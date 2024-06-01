<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ShareController;

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

// Index
Route::get('/', [IndexController::class, 'index'])->name('index');

// Categories
Route::get('/categories', [IndexController::class, 'categories'])->name('categories');

// Category
Route::get('/category/{category}', [IndexController::class, 'category'])->name('category');
Route::get('/category/{mainCategory}/{subCategory}',  [IndexController::class, 'subCategory'])->name('subCategory');

// Food
Route::get('/food', [IndexController::class, 'food'])->name('food');
Route::get('/food/{subCategory}', [IndexController::class, 'foodSubCategory'])->name('foodSubCategory');

// Search
Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/autocomplete', [IndexController::class, 'autoComplete'])->name('autocomplete');

// Offers
Route::get('/offers', [IndexController::class, 'offers'])->name('offers');

// Store
Route::get('/store/{slug}', [IndexController::class, 'store'])->name('store');

// Bday Bash
Route::get('/bday-bash', [IndexController::class, 'bday_bash'])->name('bday_bash');

// Influencer
Route::get('/influencer', [IndexController::class, 'influencer'])->name('influencer');

// Share 
Route::get('/store/{storeSlug}/post/{postId}', [ShareController::class, 'postShare'])->name('postShare');
Route::get('/offer/{offerId}', [ShareController::class, 'offerShare'])->name('offerShare');
Route::get('/store/{storeSlug}/interior', [ShareController::class, 'interiorShare'])->name('interiorShare');
Route::get('/store/{storeSlug}/featured', [ShareController::class, 'featuredShare'])->name('featuredShare');
Route::get('/store/{storeSlug}/logo', [ShareController::class, 'logoShare'])->name('logoShare');
Route::get('/featured-post/{featuredPostId}', [ShareController::class, 'featuredPostShare'])->name('featuredPostShare');
Route::get('/featured-offer/{featuredOfferId}', [ShareController::class, 'featuredOfferShare'])->name('featuredOfferShare');
Route::get('/highlight/{highlightCategory}', [ShareController::class, 'shareHighlight'])->name('shareHighlight');

// System
Route::get('/system/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage linked';
});

Route::get('/system/route-cache', function () {
    Artisan::call('route:clear');
    return 'Routes cache cleared';
});

Route::get('/system/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache cleared';
});

Route::get('/system/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache cleared';
});

Route::get('/system/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache cleared';
});