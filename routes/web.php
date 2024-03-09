<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Admin\AdminProductCategoryController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Middleware\AdminAuthWeb;
use App\Http\Middleware\VendorAuthWeb;

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

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware([AdminAuthWeb::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/product/categories', [AdminProductCategoryController::class, 'categories_list'])->name('products-categories');
        Route::get('/product/category/edit/{category_id}', [AdminProductCategoryController::class, 'edit_category']);
        Route::get('/product-sub-categories', [AdminProductCategoryController::class, 'sub_categories_list'])->name('products-sub-categories');
        Route::get('/product/category/new', [AdminProductCategoryController::class, 'new_category'])->name('new-product-category');
        Route::get('/product-category/edit/{category_id}', [AdminProductCategoryController::class, 'edit_category']);
        Route::prefix('ajax')->group(function () {
            Route::any('/product/category', [AjaxController::class, 'product_category']);
        });
    });
    Route::middleware([])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('do-login');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('do-logout');
    });
});

Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::middleware([VendorAuthWeb::class])->group(function () {
        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    });
    Route::middleware([])->group(function () {
        Route::get('/', [VendorController::class, 'index'])->name('login');
        Route::post('/login', [VendorAuthController::class, 'login'])->name('do-login');
        Route::post('/logout', [VendorAuthController::class, 'logout'])->name('do-logout');
    });
});