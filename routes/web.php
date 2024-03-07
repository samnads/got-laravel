<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\ProductCategoryController;

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


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminLoginController::class, 'showLoginForm']);
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin-login');
    Route::post('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin-login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::prefix('master')->group(function () {
        Route::get('/categories', [ProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
        Route::get('/brands', [ProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
        Route::get('/states', [ProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
