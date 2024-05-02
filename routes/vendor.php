<?php

use App\Http\Controllers\Vendor\VendorProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorDropdownController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorDeliveryPersonController;
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

Route::prefix('')->name('vendor.')->group(function () {
    Route::middleware([VendorAuthWeb::class])->group(function () {
        Route::get('/dashboard', [VendorDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [VendorController::class, 'vendor_profile'])->name('my-profile');
        Route::prefix('product')->name('product.')->group(function () {
            Route::any('/my-products', [VendorProductController::class, 'my_products'])->name('my-products');
            Route::any('/available-products', [VendorProductController::class, 'available_products'])->name('available-products');
            Route::any('/product-requests', [VendorProductController::class, 'product_requests'])->name('requests');
            Route::any('/new-request', [VendorProductController::class, 'new_product_request'])->name('new-request');
        });
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::any('/', [VendorOrderController::class, 'index']);
            Route::get('/list', [VendorOrderController::class, 'orders_list'])->name('list');
            Route::get('/filter/{status_code}', [VendorOrderController::class, 'orders_list_by_status_code'])->name('orders_list_by_status_code');
        });
        Route::prefix('masters')->name('masters.')->group(function () {
            Route::prefix('delivery-persons')->name('delivery-persons.')->group(function () {
                Route::any('/', [VendorDeliveryPersonController::class, 'index']);
                Route::get('/list', [VendorDeliveryPersonController::class, 'delivery_persons_list'])->name('list');
            });
        });
        Route::prefix('dropdown')->name('dropdown.')->group(function () {
            Route::get('brands/{usage}', [VendorDropdownController::class, 'brands']);
            Route::get('categories/{usage}', [VendorDropdownController::class, 'categories']);
            Route::get('units/{usage}', [VendorDropdownController::class, 'units']);
        });
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::any('/', [VendorProfileController::class, 'index'])->name('index');
            Route::get('view', [VendorProfileController::class, 'view'])->name('view');
            Route::get('update-password', [VendorProfileController::class, 'update_password'])->name('update-password');
        });
    });
    Route::middleware([])->group(function () {
        Route::get('/', [VendorController::class, 'vendor_login'])->name('login');
        Route::post('/login', [VendorAuthController::class, 'vendor_login'])->name('do-login');
        Route::post('/logout', [VendorAuthController::class, 'logout'])->name('do-logout');
    });
})->domain('vendor.' . env('DOMAIN'));