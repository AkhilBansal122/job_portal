<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\RegisteredUserController;
use App\Http\Controllers\Api\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\employeeUser\Auth\AuthenticatedSessionController as EmployeeAuthenticatedSessionController;
use App\Http\Controllers\Api\employeeUser\Auth\RegisteredUserController as EmployeeRegisteredUserController;
use App\Http\Controllers\Api\User\Auth\PasswordResetLinkController as UserPasswordResetLinkController;
use App\Http\Controllers\Api\VerifyOtpController;



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
    // Route::post('verifyOtp', [VerifyOtpController::class, 'verifyOtp']);
    Route::post('/password-reset-link', [UserPasswordResetLinkController::class, 'store'])->name('password.reset.link');
    Route::post('verify-otp', [VerifyOtpController::class, 'verifyOtp']);
    Route::post('reset-password', [VerifyOtpController::class, 'resetPassword']);




    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
        Route::get('profile', [AuthenticatedSessionController::class, 'profile']);
        

    });
});


Route::group(['prefix' => 'employeeUser'], function () {
    Route::post('register', [EmployeeRegisteredUserController::class, 'store']);
    Route::post('employee-login', [EmployeeAuthenticatedSessionController::class, 'store']);
    Route::post('verifyOtp', [VerifyOtpController::class, 'verifyOtp']);


    Route::middleware('auth:employeeUser')->group(function () {
        Route::post('logout', [EmployeeAuthenticatedSessionController::class, 'destroy']);
        Route::get('profile', [EmployeeAuthenticatedSessionController::class, 'profile']);
        

    });
});