<?php

use App\Http\Controllers\admin\api\AuthController;
use App\Http\Controllers\admin\api\PaypalController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('signup',[AuthController::class,'signup']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);



Route::post('paypal',[PaypalController::class,'payWithPaypal'])->name('paypal');
Route::post('/paypal/status', [PaypalController::class, 'getPaymentStatus'])->name('api.paypal.status');
