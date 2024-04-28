<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorDropdownController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorDeliveryPersonController;
use App\Http\Controllers\Admin\AdminProductCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminStateController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Middleware\AdminAuthWeb;
use App\Http\Middleware\VendorAuthWeb;
use App\Http\Middleware\UserAuthWeb;
// User Imports
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserProductCategoryController;
use App\Http\Controllers\User\UserBrandController;
use App\Http\Controllers\User\UserVendorController;
use App\Http\Controllers\User\UserDropdownController;

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
        Route::get('/product/block/{product_id}', [AdminProductController::class, 'product_block'])->name('product-block');
        Route::get('/product/unblock/{product_id}', [AdminProductController::class, 'product_unblock'])->name('product-unblock');
        Route::get('/product/list', [AdminProductController::class, 'product_list'])->name('product-list');
        Route::get('/product/new', [AdminProductController::class, 'product_new'])->name('product-new');
        Route::get('/product/edit/{product_id}', [AdminProductController::class, 'product_edit']);
        Route::post('/product/update', [AdminProductController::class, 'product_update']);
        Route::get('/product/categories', [AdminProductCategoryController::class, 'categories_list'])->name('products-categories');
        Route::get('/product/category/edit/{category_id}', [AdminProductCategoryController::class, 'edit_category']);
        Route::get('/product/sub-category/edit/{category_id}', [AdminProductCategoryController::class, 'edit_sub_category']);
        Route::get('/product/sub-categories', [AdminProductCategoryController::class, 'sub_categories_list'])->name('products-sub-categories');
        Route::get('/product/category/new', [AdminProductCategoryController::class, 'new_category'])->name('new-product-category');
        Route::get('/product/sub-category/new', [AdminProductCategoryController::class, 'new_sub_category'])->name('new-product-category');
        Route::get('/product-category/edit/{category_id}', [AdminProductCategoryController::class, 'edit_category']);
        Route::post('/product', [AdminProductController::class, 'product_save'])->name('product-save');
        Route::get('/brands', [AdminBrandController::class, 'brands_list'])->name('brands');
        Route::get('/brand/edit/{brand_id}', [AdminBrandController::class, 'edit_brand']);
        Route::get('/brand/new', [AdminBrandController::class, 'new_brand']);
        Route::prefix('vendor')->group(function () {
            Route::any('/', [AdminVendorController::class, 'index']);
            Route::get('/list', [AdminVendorController::class, 'vendors_list'])->name('vendors');
            Route::get('/new', [AdminVendorController::class, 'vendor_new']);
            Route::get('/edit/{vendor_id}', [AdminVendorController::class, 'vendor_edit']);
            Route::get('/block/{vendor_id}', [AdminVendorController::class, 'block_vendor']);
            Route::get('/unblock/{vendor_id}', [AdminVendorController::class, 'unblock_vendor']);
        });
        Route::get('/states', [AdminStateController::class, 'states_list'])->name('states');
        Route::prefix('locations')->group(function () {
            Route::get('/list', [AdminLocationController::class, 'locations_list'])->name('locations');
        });
        Route::prefix('ajax')->group(function () {
            Route::any('/location', [AjaxController::class, 'location']);
            Route::any('/brand', [AjaxController::class, 'brand']);
            Route::any('/product/category', [AjaxController::class, 'product_category']);
            Route::any('/product/sub-category', [AjaxController::class, 'product_sub_category']);
            Route::get('/dropdown/get-districts', [AjaxController::class, 'get_districts_by_state']);
            Route::get('/dropdown/get-location', [AjaxController::class, 'get_location_by_id']);
            Route::get('/dropdown/get-locations', [AjaxController::class, 'get_locations_by_district']);
        });
    });
    Route::middleware([])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('do-login');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('do-logout');
    });
});
Route::prefix('user')->name('user.')->group(function () {
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
        });
        Route::prefix('dropdown')->name('dropdown.')->group(function () {
            Route::get('districts/{usage}', [UserDropdownController::class, 'districts']);
            Route::get('locations/{usage}', [UserDropdownController::class, 'locations']);
        });
    });
});
Route::prefix('vendor')->name('vendor.')->group(function () {
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
            Route::get('/list', [VendorOrderController::class, 'orders_list'])->name('list');
            Route::get('/filter/{status_code}', [VendorOrderController::class, 'orders_list_by_status_code'])->name('orders_list_by_status_code');
        });
        Route::prefix('masters')->name('masters.')->group(function () {
            Route::prefix('delivery-persons')->name('delivery-persons.')->group(function () {
                Route::any('/', [VendorDeliveryPersonController::class, 'index']);
                Route::get('/list', [VendorDeliveryPersonController::class, 'delivery_persons_list'])->name('list');
            });
        });
    });
    Route::prefix('dropdown')->name('dropdown.')->group(function () {
        Route::get('brands/{usage}', [VendorDropdownController::class, 'brands']);
        Route::get('categories/{usage}', [VendorDropdownController::class, 'categories']);
        Route::get('units/{usage}', [VendorDropdownController::class, 'units']);
    });
    Route::middleware([])->group(function () {
        Route::get('/', [VendorController::class, 'vendor_login'])->name('login');
        Route::post('/login', [VendorAuthController::class, 'vendor_login'])->name('do-login');
        Route::post('/logout', [VendorAuthController::class, 'logout'])->name('do-logout');
    });
});