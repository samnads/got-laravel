<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\Api\LoginController;
use App\Http\Controllers\Customer\Api\ProfileController;
use App\Http\Controllers\Customer\Api\AddressController;

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
        Route::post('update_profile', [ProfileController::class, 'basic_data_entry']);
        Route::post('save_address', [AddressController::class, 'create_address']);
        Route::post('update_address', [AddressController::class, 'update_address']);
    });
});