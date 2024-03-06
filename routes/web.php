<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
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
    //Route::get('/', [AdminController::class, 'login']);
    Route::get('/login', [AdminController::class, 'login'])->name('admin-login');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::prefix('products')->group(function () {
        Route::get('/categories', [ProductCategoryController::class, 'categories_list'])->name('admin-products-categories');
    });
});
