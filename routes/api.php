<?php

use App\Http\Controllers\Callbacks;
use App\Http\Controllers\PaymentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('generate-vouchers',[App\Http\Controllers\VouchersController::class,'generateApi']);
    Route::get('generate-voucher',[App\Http\Controllers\VouchersController::class,'generateVoucherApi']);
    Route::get('products',[App\Http\Controllers\VouchersController::class,'getOrganizationProducts']);
    Route::post('redeem',[App\Http\Controllers\VouchersController::class,'directDispatchApi']);
});
Route::any('sms',[\App\Http\Controllers\Api\SmsController::class,'receive']);
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\Auth\AuthController::class,'login'])->name(' api login');
    Route::post('register', [App\Http\Controllers\Auth\AuthController::class,'register']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', [App\Http\Controllers\Auth\AuthController::class,'logout']);
        Route::get('user', [App\Http\Controllers\Auth\AuthController::class,'user']);

    });
});
Route::domain('payments.tamaituk.com')->group(function(){
    Route::get('register',[PaymentsController::class,'register'])->name('register_callback');
    Route::post('/b2ccallback',[Callbacks::class,'processB2CRequestCallback']);
    Route::post("/b2bcallback",[Callbacks::class,'processB2BRequestCallback']);
    Route::post('/c2bvalidation',[Callbacks::class,'C2BRequestValidation']);
    Route::post('/c2bconfirmation',[Callbacks::class,'processC2BRequestConfirmation']);
    Route::post('/accountbalance',[Callbacks::class,'processAccountBalanceRequestCallback']);
    Route::post('/reversalcallback',[Callbacks::class,'processReversalRequestCallBack']);
    Route::post('/requeststkcallback',[Callbacks::class,'processSTKPushRequestCallback']);
    Route::post('/querystkcallback',[Callbacks::class,'processSTKPushQueryRequestCallback']);
    Route::post('/transstatcallback',[Callbacks::class,'processTransactionStatusRequestCallback']);
});




