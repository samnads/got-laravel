<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminProductCategoryController;
use App\Http\Middleware\AdminAuthWeb;

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


Route::prefix('admin')->name('admin.')->middleware([AdminAuthWeb::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::prefix('master')->group(function () {
        Route::get('/product-categories', [AdminProductCategoryController::class, 'categories_list'])->name('products-categories');
        Route::get('/product-category/new', [AdminProductCategoryController::class, 'new_category'])->name('products-categories');
        Route::post('/product-category/save', [AdminProductCategoryController::class, 'save_category'])->name('products-categories');
        //Route::get('/brands', [AdminProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
        //Route::get('/states', [AdminProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
        //Route::get('/districts', [AdminProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
    });
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('do-login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('do-logout');
});