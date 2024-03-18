<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Api\LoginController;
use App\Http\Controllers\Customer\Api\ProfileController;
use App\Http\Controllers\Customer\Api\AddressController;
use App\Http\Controllers\Customer\Api\ProductCategoriesController;
use App\Http\Controllers\Customer\Api\VendorController;
use App\Http\Controllers\Customer\Api\VendorProductController;
use App\Http\Controllers\Customer\Api\CartController;
//
use App\Http\Controllers\Admin\Api\VendorController as AdminVendorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('customer')->group(function () {
    Route::get('/', function (Request $request) {
        return '<h1>'.env('APP_NAME').'</h1><br>You\'re in customer app API base url 😀 !';
    });
    Route::post('register', [LoginController::class, 'login_otp_send']);
    Route::post('resend_otp', [LoginController::class, 'login_otp_resend']);
    Route::post('verify', [LoginController::class, 'login_otp_verify']);
    Route::group(['middleware' => 'customerApiTokenCheck'], function () {
        Route::post('register_profile', [ProfileController::class, 'basic_data_entry']);
        Route::post('update_profile', [ProfileController::class, 'update_profile']);
        Route::post('profile', [ProfileController::class, 'get_profile']);
        Route::post('save_address', [AddressController::class, 'create_address']);
        Route::post('update_address', [AddressController::class, 'update_address']);
        Route::post('set_default_address', [AddressController::class, 'update_default_address']);
        Route::post('delete_address', [AddressController::class, 'delete_address']);
        Route::post('default_address', [AddressController::class, 'get_default_address']);
        Route::post('address_list', [AddressController::class, 'list_all_address']);
        Route::post('product_categories', [ProductCategoriesController::class, 'categories']);
        Route::post('product_sub_categories', [ProductCategoriesController::class, 'sub_categories']);
        Route::post('nearby_shops', [VendorController::class, 'nearby_vendors']);
        Route::post('shop_locations', [VendorController::class, 'vendors_locations']);
        Route::post('vendor_products', [VendorProductController::class, 'vendor_products']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::post('cart', [CartController::class, 'get_cart']);
        Route::post('update_cart', [CartController::class, 'update_cart']);
    });
});
Route::prefix('admin')->group(function () {
    Route::get('/', function (Request $request) {
        return '<h1>' . env('APP_NAME') . '</h1><br>You\'re in admin app API base url 😀 !';
    });
    Route::post('save_vendor', [AdminVendorController::class, 'save_vendor']);
});