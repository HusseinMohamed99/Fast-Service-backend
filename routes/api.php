<?php

use App\Http\Controllers\Admin\All_CustomerController;
use App\Http\Controllers\Admin\All_WorkerController;
use App\Http\Controllers\Admin\Delete_UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyEmailController;
use  App\Http\Controllers\core\authantication\LogoutController;
use  App\Http\Controllers\core\authantication\ValidOTPController;
use  App\Http\Controllers\core\authantication\ChangePasswordController;
use  App\Http\Controllers\core\authantication\DeleteAccountController;
use  App\Http\Controllers\core\authantication\ResendOTPCodeController;
use  App\Http\Controllers\core\authantication\ResetPasswordController;
use  App\Http\Controllers\core\authantication\ForgetPasswordController;
use App\Http\Controllers\core\Home\GetCategoryController;
use App\Http\Controllers\core\Home\ListWorkerController;
use App\Http\Controllers\core\Home\recommendedController;
use App\Http\Controllers\core\Home\SearchController as HomeSearchController;
use App\Http\Controllers\Customer\Profile\GetProfileController;
use App\Http\Controllers\Customer\Profile\UpdateProfileController;
use App\Http\Controllers\Customer\Saved\SavedPageController;
use App\Http\Controllers\Customer\Saved\Search_SaveWorkerController;
use App\Http\Controllers\Customer\Saved\UnSave_SaveWorkerController;
use App\Http\Controllers\Customer\WorkerDetailsController;
use App\Http\Controllers\Worker\InformationWorkerController;


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


//  API  routes user/auth
Route::group(['prefix' => 'v1/user'], function () {
    Route::post('/auth/register', RegisterController::class);
    Route::post('/auth/login', LoginController::class);
    Route::post('/auth/forget_password', ForgetPasswordController::class);
    Route::post('/auth/resend_otp', ResendOTPCodeController::class);
    Route::post('/auth/reset_password', ResetPasswordController::class);
    Route::post('/auth/check_otp', ValidOTPController::class);
    Route::get('/category', GetCategoryController::class);


    // API routes for middleware seeker token authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::post('/auth/verify_email', VerifyEmailController::class);
        Route::post('/auth/change_password', ChangePasswordController::class);
        Route::post('/auth/delete_account', DeleteAccountController::class);
        Route::post('/auth/logout', LogoutController::class);
        Route::Get('/auth/get_profile', GetProfileController::class);
        Route::get('/home/List_worker', ListWorkerController::class);
        Route::get('/home/recommended', recommendedController::class);


    });
});

//  API  routes customer/auth
Route::group(['prefix' => 'v1/customer'], function () {

    Route::get('/search', HomeSearchController::class);
    Route::get('/worker_details', WorkerDetailsController::class);
    Route::get('/search_saved', Search_SaveWorkerController::class);


    // API routes for middleware seeker token authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/update_profile', UpdateProfileController::class);
        Route::post('/update_informatiom', InformationWorkerController::class);
        Route::get('/saved_page', SavedPageController::class);
        Route::post('/save_unsaved', UnSave_SaveWorkerController::class);


    });

});

Route::group(['prefix' => 'v1/worker'], function () {


    // API routes for middleware seeker token authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/update_informatiom', InformationWorkerController::class);


    });

});


Route::group(['prefix' => 'v1/admin'], function () {

    // API routes for middleware seeker token authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/all_customer', All_CustomerController::class);
        Route::get('/all_worker', All_WorkerController::class);
        Route::post('/delete_user', Delete_UserController::class);


    });

});
