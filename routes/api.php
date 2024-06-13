<?php

use App\Http\Controllers\Api\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'IpWhiteList'], function () {
    Route::post('store', [ApiController::class, 'store']);
    // Route::get('index', [ApiController::class, 'index']);
    Route::get('index', function () { return bcrypt("password"); });
    Route::get('auth', [ApiController::class, 'auth']);
    Route::get('register-invoice', [ApiController::class, 'registerInvoice']);
    Route::get('test', [ApiController::class, 'inquiry']);
});