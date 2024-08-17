<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\RegisteredUserController;
use App\Http\Controllers\Api\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\employeeUser\Auth\AuthenticatedSessionController as EmployeeAuthenticatedSessionController;
use App\Http\Controllers\Api\employeeUser\Auth\RegisteredUserController as EmployeeRegisteredUserController;
use App\Http\Controllers\Api\User\Auth\PasswordResetLinkController as UserPasswordResetLinkController;
use App\Http\Controllers\Api\VerifyOtpController;
use App\Http\Controllers\Api\Common\CommonController;
use App\Http\Controllers\Api\Common\ResendOtpController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::get('/user', function (Request $request) {
//     $data = "hello";
//     return $data;
// })->middleware('auth:sanctum');
Route::group(['prefix' => 'user'], function () {

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('verify-otp', [CommonController::class, 'verifyOtp']);
    Route::post('resend-otp', [CommonController::class, 'resendOtp']);
    Route::post('forgot-password', [CommonController::class, 'forgotPassword']);
    Route::post('reset-password', [CommonController::class, 'resetPassword']);

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
        Route::get('profile', [AuthenticatedSessionController::class, 'profile']);
        Route::post('change-password', [CommonController::class, 'changePassword']);
    });
});


Route::group(['prefix' => 'employeeUser'], function () {
    Route::post('register', [EmployeeRegisteredUserController::class, 'store']);
    Route::post('login', [EmployeeAuthenticatedSessionController::class, 'store']);
    Route::post('verify-otp', [CommonController::class, 'verifyOtp']);
    Route::post('resend-otp', [CommonController::class, 'resendOtp']);
    Route::post('forgot-password', [CommonController::class, 'forgotPassword']);
    Route::post('reset-password', [CommonController::class, 'resetPassword']);


    Route::middleware('auth:employeeUser')->group(function () {
        Route::post('logout', [EmployeeAuthenticatedSessionController::class, 'destroy']);
        Route::get('profile', [EmployeeAuthenticatedSessionController::class, 'profile']);
        Route::post('change-password', [CommonController::class, 'changePassword']);
    });
});
