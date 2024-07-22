<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\employeeUser\EmployeeUserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\services\ServicesController;
use App\Http\Controllers\Admin\userProfileController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;


// Route::get('', function () {
//     return view('welcome');
// });
// Route::get('dash', function () {
//     return view('admin.layouts.datatable');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//****************************** Admin route start here ******************************************* */
Route::group(['namespace' => 'App\Http\Controllers\Admin\Auth'], function () {
    Route::get('/', 'AuthenticatedSessionController@create')->name('admin.login');
    Route::post('admin/login', 'AuthenticatedSessionController@store')->name('postLogin');
    Route::get('admin/fortgot-password', 'PasswordResetLinkController@create')->name('admin.forgotPassword');
    Route::post('admin/fortgot-password', 'PasswordResetLinkController@store')->name('admin.resetPassword');
    // Route::post('admin/reset-password', [PasswordResetLinkController::class, 'store'])->name('admin.resetPassword');
    
    Route::get('admin/reset-password/{token}', [PasswordResetLinkController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('admin/reset-password', [PasswordResetLinkController::class, 'submitResetPasswordForm'])->name('reset.password.post');

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('adminDashboard');
    Route::group(['namespace' => 'App\Http\Controllers\Admin\Auth'], function () {
        Route::post('logout', 'AuthenticatedSessionController@destroy')->name('adminlogout');
    });
    Route::get('/profile', 'ProfileController@index')->name('admin.profile');
    Route::resource('section', SectionController::class);
    // Route::resource('job-categories', CategoryController::class);

    Route::resource('jobs', JobController::class);
    Route::resource('home-page', HomePageController::class);
    Route::get('users/data', [SectionController::class, 'getData'])->name('users.data');
    Route::post('sectionAjax', [SectionController::class, 'sectionAjax'])->name('sectionAjax');
    Route::get('edit-section', [SectionController::class, 'editSection'])->name('editSection');
    Route::post('delete-section', [SectionController::class, 'deleteSection'])->name('deleteSection');
    Route::post('change-status', [SectionController::class, 'changeStatus'])->name('changeStatus');

    Route::get('user', [UserController::class, 'index'])->name('users.index');
    Route::post('user-ajax', [UserController::class, 'userAjax'])->name('userAjax');
    Route::post('chnage-user-status', [UserController::class, 'changeUserStatus'])->name('changeUserStatus');


    Route::get('employee-users', [EmployeeUserController::class, 'index'])->name('employeeUsers.index');
    Route::post('employee-users-ajax', [EmployeeUserController::class, 'employeeUsersAjax'])->name('employeeUsersAjax');
    Route::post('change-status-employee-users', [EmployeeUserController::class, 'changeEmployeeUserStatus'])->name('changeEmployeeUserStatus');

    // Job and Job_category rrelated route
    Route::resource('job-categories', CategoryController::class);
    Route::post('job-categories/ajax', [CategoryController::class, 'jobCategoryAjax'])->name('jobCategoryAjax');
    Route::post('job-categories/status', [CategoryController::class, 'changeJobCategoryStatus'])->name('changeJobCategoryStatus');
    // Route::post('job-categories/delete/{id}', [CategoryController::class, 'destroy'])->name('job-categories.destroy');

    // Job related route is here
    Route::resource('jobs', JobController::class);
    Route::post('jobs/ajax', [JobController::class, 'jobAjax'])->name('jobAjax');
    Route::post('jobs/status', [JobController::class, 'changeJobStatus'])->name('changeJobStatus');

    // Banner related route
    Route::resource('banners', BannerController::class);
    Route::post('banners/ajax', [BannerController::class, 'bannerAjax'])->name('bannerAjax');
    Route::post('banners/status', [BannerController::class, 'changeBannerStatus'])->name('changeBannerStatus');

     // Services related route
     Route::resource('services', ServicesController::class);
     Route::post('services/ajax', [ServicesController::class, 'servicesAjax'])->name('servicesAjax');
     Route::post('services/status', [ServicesController::class, 'changeServicesStatus'])->name('changeServicesStatus');

    Route::get('/userprofile', [UserprofileController::class, 'index'])->name('userprofile');
    Route::post('/userprofile', [UserprofileController::class, 'store'])->name('user.profile.store');

});


//****************************** Admin route end here ******************************************* */

Route::get('test',[TestController::class, 'index'])->name('ddddd');

Route::get('/password', [ChangePasswordController::class, 'index'])->name('password');
Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])->name('update-password');

require __DIR__ . '/auth.php';
