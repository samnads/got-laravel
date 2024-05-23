<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAuthWeb;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProductCategoryController;
use App\Http\Controllers\User\UserBrandController;
use App\Http\Controllers\User\UserVendorController;
use App\Http\Controllers\User\UserDropdownController;
use App\Http\Controllers\User\UserLocationController;
use App\Http\Controllers\User\UserDistrictController;
use App\Http\Controllers\User\UserStateController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\VendorOrderController;
use App\Http\Controllers\User\VendorInvoiceController;
use App\Http\Controllers\User\VendorPaymentController;

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
Route::prefix('')->name('user.')->group(function () {
    // Authentication Routes
    Route::middleware([])->group(function () {
        Route::get('/', [UserAuthController::class, 'login'])->name('login');
        Route::post('/login', [UserAuthController::class, 'login'])->name('do-login');
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('do-logout');
    });
    // Authentication Routes End
    Route::middleware([UserAuthWeb::class])->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
        // Masters Routes
        Route::prefix('masters')->name('masters.')->group(function () {
            // Category routes
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::post('/', [UserProductCategoryController::class, 'add_category']);
                Route::get('/list', [UserProductCategoryController::class, 'categories_list'])->name('list');
                Route::get('/{category_id}', [UserProductCategoryController::class, 'get_category']);
                Route::put('/{category_id}', [UserProductCategoryController::class, 'update_category']);
            });
            // Brand routes
            Route::prefix('brands')->name('brands.')->group(function () {
                Route::post('/', [UserBrandController::class, 'add_brand']);
                Route::get('/list', [UserBrandController::class, 'brands_list'])->name('list');
                Route::get('/{brand_id}', [UserBrandController::class, 'get_brand']);
                Route::put('/{brand_id}', [UserBrandController::class, 'update_brand']);
            });
            // Vendors routes
            Route::prefix('vendors')->name('vendors.')->group(function () {
                Route::post('/', [UserVendorController::class, 'create']);
                Route::get('/list', [UserVendorController::class, 'list'])->name('list');
                Route::get('/{id}', [UserVendorController::class, 'read']);
                Route::put('/{id}', [UserVendorController::class, 'update']);
            });
            // Location routes
            Route::prefix('locations')->name('locations.')->group(function () {
                Route::post('/', [UserLocationController::class, 'add_location']);
            });
            // District routes
            Route::prefix('districts')->name('districts.')->group(function () {
                Route::post('/', [UserDistrictController::class, 'add_district']);
            });
            // State routes
            Route::prefix('states')->name('states.')->group(function () {
                Route::post('/', [UserStateController::class, 'add_state']);
            });
        });
        // Products routes
        Route::prefix('products')->name('products.')->group(function () {
            Route::post('/', [UserProductController::class, 'create']);
            Route::get('/new', [UserProductController::class, 'new_product'])->name('new-product');
            Route::post('/new', [UserProductController::class, 'new_product'])->name('save-product');
            Route::get('/list', [UserProductController::class, 'list'])->name('list');
            Route::get('/{id}', [UserProductController::class, 'read']);
            Route::put('/{id}', [UserProductController::class, 'update']);
        });
        Route::prefix('dropdown')->name('dropdown.')->group(function () {
            Route::get('districts/{usage}', [UserDropdownController::class, 'districts']);
            Route::get('locations/{usage}', [UserDropdownController::class, 'locations']);
            Route::get('categories/{usage}', [UserDropdownController::class, 'categories']);
            Route::get('vendors/{usage}', [UserDropdownController::class, 'vendors']);
            Route::get('invoices/{usage}', [UserDropdownController::class, 'invoices']);
        });
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::any('/', [UserProfileController::class, 'index'])->name('index');
            Route::get('update-password', [UserProfileController::class, 'update_password'])->name('update-password');
        });
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/list', [VendorOrderController::class, 'orders_list'])->name('list');
        });
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('invoices', [VendorInvoiceController::class, 'invoices'])->name('invoices');
            Route::get('/invoices/pdf/{invoice_id}', [VendorInvoiceController::class, 'invoice_pdf_view']);
            Route::post('invoices', [VendorInvoiceController::class, 'create_invoice']);
            Route::get('payments', [VendorPaymentController::class, 'payments'])->name('payments');
            Route::post('payments', [VendorPaymentController::class, 'add_payment']);
        });
    });
})->domain('manage.' . env('DOMAIN'));