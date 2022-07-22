<?php

use App\Http\Controllers\AccessTypeController;
use App\Http\Controllers\CredentialsController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\OrgProductController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\RatesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VouchersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/',[LoginController::class,'showLoginForm'])->name('login form');
//Route::get('/test',[\App\Http\Controllers\TamaitukController::class,'index']);
//Route::post('login',[Auth\LoginController::class,'login'])->name('login');


Route::group([ 'role'=>['admin','audit'],'middleware'=>['auth','domain','org'],'prefix'=>'backend'], function () {

    Route::get('/test', [LoginController::class, 'test']);

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('organization', OrganizationController::class);
    Route::post('/organization/get', [OrganizationController::class, 'get'])->name('organization.datatable');

    Route::resource('organization.product', OrgProductController::class);
    Route::post('/organization/{orgid}/get', [OrgProductController::class, 'get'])->name('organization.product.datatable');
    Route::get('/organization/{orgid}/check', [OrgProductController::class, 'check'])->name('organization.product.check');

    Route::resource('product_type', ProductTypeController::class);
    Route::post('/product-type/get', [ProductTypeController::class, 'get'])->name('product_type.datatable');

    Route::resource('access_type', AccessTypeController::class);
    Route::post('/access-type/get', [AccessTypeController::class, 'get'])->name('access_type.datatable');

    Route::resource('product', ProductController::class);
    Route::post('/product/get', [ProductController::class, 'get'])->name('product.datatable');

    Route::resource('rates', RatesController::class);
    Route::post('rates/get', [RatesController::class, 'get'])->name('rates.datatable');

    Route::resource('credits', CreditController::class);
    Route::post('/credits/get', [CreditController::class, 'get'])->name('credits.datatable');

    Route::resource('transaction', TransactionsController::class);
    Route::post('/transaction/get', [TransactionsController::class, 'get'])->name('transaction.datatable');


    Route::resource('user', UserController::class);
    Route::post('user/get', [UserController::class, 'get'])->name('user.datatable');
    Route::get('user/export', [UserController::class, 'export_view'])->name('user.export_view');
    Route::post('user/export', [UserController::class, 'export'])->name('user.export');

    Route::resource('user.role', RolesController::class);
    Route::post('user/{user}/role/get', [RolesController::class, 'get'])->name('user.role.datatable');
    Route::get('user/{user}/role/export', [RolesController::class, 'export_view'])->name('user.role.export_view');
    Route::post('user/{user}/role/export', [RolesController::class, 'export'])->name('user.role.export');


    Route::resource('user.permission', PermissionsController::class);
    Route::post('permission/get', [PermissionsController::class, 'get'])->name('user.permission.datatable');
    Route::get('permission/export', [PermissionsController::class, 'export_view'])->name('user.permission.export_view ');
    Route::post('permission/export', [PermissionsController::class, 'export'])->name('user.permission.export');



    Route::prefix('jobs')->group(function () {
        Route::get('/failed', [JobsController::class, 'failed'])->name('job.failed');
        Route::post('/failed/get',[JobsController::class,'get_failed'])->name('job.failed_datatable');

        Route::get('/queued',[JobsController::class,'queued'])->name('job.queued');
        Route::post('/queued/get',[JobsController::class,'get_queued'])->name('job.queued_datatable');
    });


    Route::resource('log',LogsController::class);
    Route::post('log/get',[LogsController::class,'get'])->name('log.datatable');
    Route::get('log/export',[LogsController::class,'export_view'])->name('log.export_view');
    Route::post('log/export',[LogsController::class,'export'])->name('log.export');

    Route::resource('disbursement',\App\Http\Controllers\DisbursementController::class);
    Route::post('/get',[\App\Http\Controllers\DisbursementController::class,'get'])->name('disbursement.datatable');
    Route::get('/export',[\App\Http\Controllers\DisbursementController::class,'export_view'])->name('disbursement.export_view');
    Route::post('/export',[\App\Http\Controllers\DisbursementController::class,'export'])->name('disbursement.export');

    Route::resource('ticket_category',\App\Http\Controllers\TicketCategoryController::class);
    Route::post('/get',[\App\Http\Controllers\TicketCategoryController::class,'get'])->name('ticket_category.datatable');

    Route::resource('category.ticket',\App\Http\Controllers\TicketCategoryController::class);
    Route::post('/get',[\App\Http\Controllers\TicketCategoryController::class,'get'])->name('category.ticket.datatable');

    Route::prefix('security')->group(function(){
        Route::get('/credentials',[CredentialsController::class,'index'])->name('credentials');
        Route::post('/generate',[CredentialsController::class,'generateCredentials'])->name('credentials.generate');
    });

    Route::prefix('vouchers')->group(function(){
        Route::get('/',[VouchersController::class,'index'])->name('vouchers.list');
        Route::post('/get',[VouchersController::class,'get'])->name('vouchers.get');
        Route::get('/generate',[VouchersController::class,'getGenerator'])->name('vouchers.generate.get');
        Route::post('/generate',[VouchersController::class,'generate'])->name('vouchers.generate');
        Route::get('/batches',[VouchersController::class,'batches'])->name('vouchers.batches');
        Route::post('/batches',[VouchersController::class,'getBatches'])->name('vouchers.batches.get');
    });

    Route::get('/documentation',[CredentialsController::class,'documentation'])->name('documentation');
});
