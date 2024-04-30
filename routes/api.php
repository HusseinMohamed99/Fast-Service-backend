<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Requests\Auth\changePasswordRequest;
use  App\Http\Controllers\core\authantication\LogoutController;
use  App\Http\Controllers\core\authantication\ValidOTPController;
use  App\Http\Controllers\core\authantication\ChangePasswordController;
use  App\Http\Controllers\core\authantication\DeleteAccountController;
use  App\Http\Controllers\core\authantication\ResendOTPCodeController;
use  App\Http\Controllers\core\authantication\ResetPasswordController;
use  App\Http\Controllers\core\authantication\ForgetPasswordController;
use App\Http\Controllers\Customer\Home\HomeController;
use App\Http\Controllers\Customer\Home\SearchController;
use App\Http\Controllers\Customer\Profile\UpdateProfileController;
use App\Http\Controllers\Customer\Saved\SavedPageController;
use App\Http\Controllers\Customer\Saved\Search_SaveWorkerController;
use App\Http\Controllers\Customer\Saved\UnSave_SaveWorkerController;
use App\Http\Controllers\Customer\WorkerDetailsController;
use App\Http\Controllers\Worker\HomeWorkerController;
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
Route::group(['prefix' => 'v1/user/auth'], function () {
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);
    Route::post('/forget_password', ForgetPasswordController::class);
    Route::post('/resend_otp', ResendOTPCodeController::class);
    Route::post('/reset_password', ResetPasswordController::class);
    Route::post('/check_otp', ValidOTPController::class);


    // API routes for middleware seeker token authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {

         Route::post('/verify_email', VerifyEmailController::class);
        Route::post('/change_password', ChangePasswordController::class);
        Route::post('/delete_account', DeleteAccountController::class);
        Route::post('/logout', LogoutController::class);

    });
});

//  API  routes customer/auth
Route::group(['prefix' => 'v1/customer'], function () {

    Route::get('/home', HomeController::class);
    Route::get('/search', SearchController::class);
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
        Route::Get('/home', HomeWorkerController::class);


    });

});
