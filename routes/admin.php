<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
// Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HighlightController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BillboardController;
use App\Http\Controllers\Admin\FeaturedPostsController;
use App\Http\Controllers\Admin\FeaturedSectionsController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\CategorySerialController;
use App\Http\Controllers\Admin\FeaturedOffersController;
use App\Http\Controllers\Admin\FeaturedStoresController;
use App\Http\Controllers\Admin\ProductServiceController;

// Auth
Route::group(['prefix' => 'admin-auth', 'middleware' => 'guest', 'as' => 'adminAuth.'], function () {
    Route::get('/login', [LoginController::class, 'loginForm'])->name('loginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/reset-password', [ResetPasswordController::class, 'resetPasswordForm'])->name('resetPasswordForm');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('resetPassword');

    Route::get('/new-password/{token}', [ResetPasswordController::class, 'newPasswordForm'])->name('newPasswordForm');
    Route::post('/new-password', [ResetPasswordController::class, 'newPassword'])->name('newPassword');
});

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/get-subcategories', [DashboardController::class, 'getSubcategories'])->name('getSubcategories');
    Route::delete('/remove-gallery-item/{id}', [DashboardController::class, 'galleryItemRemove'])->name('galleryItemRemove');

    Route::resource('users', UserController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');

    Route::resource('stores', StoreController::class)->except('show');
    Route::post('/get-subcategories', [StoreController::class, 'getSubcategories'])->name('getSubcategories');
    Route::delete('/remove-gallery-item/{id}', [StoreController::class, 'galleryItemRemove'])->name('galleryItemRemove');

    Route::resource('billboards', BillboardController::class)->except('show');

    Route::resource('featured-posts', FeaturedPostsController::class)->except('show');
    Route::delete('featured-post-image-remove', [FeaturedPostsController::class, 'removeImage'])->name('featuredPostsRemoveImage');

    Route::resource('featured-offers', FeaturedOffersController::class)->except('show');
    Route::delete('featured-offer-image-remove', [FeaturedPostsController::class, 'removeImage'])->name('featuredOffersRemoveImage');

    Route::resource('featured-stores', FeaturedStoresController::class)->except('show');
    Route::resource('featured-sections', FeaturedSectionsController::class)->except('show');

    Route::resource('offers', OfferController::class)->except('show');
    Route::delete('offer-image-remove', [OfferController::class, 'removeImage'])->name('offers.removeImage');

    Route::resource('highlights', HighlightController::class)->except('show');
    Route::post('/get-slots', [HighlightController::class, 'getSlots'])->name('getHighlightSlots');

    Route::resource('posts', PostController::class)->except('show');
    Route::delete('post-image-remove', [PostController::class, 'removeImage'])->name('posts.removeImage');

    Route::get('category-serial', [CategorySerialController::class, 'index'])->name('category_serial.index');
    Route::get('category-serial/{sec}/edit', [CategorySerialController::class, 'edit'])->name('category_serial.edit');
    Route::put('category-serial/{sec}', [CategorySerialController::class, 'update'])->name('category_serial.update');
    Route::delete('category-serial/{sec}', [CategorySerialController::class, 'destroy'])->name('category_serial.destroy');

    // Products and Services
    Route::get('/products-services', [ProductServiceController::class, 'productsServices'])->name('products_services');
    Route::get('/admin/{word}/similar-word', [ProductServiceController::class, 'similarWord'])->name('similar_word');
    Route::put('/admin/{id}/similar-word', [ProductServiceController::class, 'updateSimilarWord'])->name('update_similar_word');

    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
});
