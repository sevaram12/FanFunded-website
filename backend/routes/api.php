<?php

use App\Http\Controllers\admin\api\AuthController;
use App\Http\Controllers\admin\api\BillingController;
use App\Http\Controllers\admin\api\PaypalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\api\SportController;


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


//------------------------------Login and Singup--------------------------------------------------//

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);





//--------------------------------------sports-------------------------------------------------------//

Route::get('/sports', [SportController::class, 'sports']);
Route::get('/odds', [SportController::class, 'odds']);
Route::get('/scores', [SportController::class, 'scores']);
Route::get('/events', [SportController::class, 'events']);
Route::get('/getEventOdds', [SportController::class, 'getEventOdds']);
Route::get('/participants', [SportController::class, 'participants']);
Route::get('/historical_odds', [SportController::class, 'historical_odds']);
Route::get('/historicalevents', [SportController::class, 'historicalevents']);
Route::get('/historical_event_odds', [SportController::class, 'historical_event_odds']);



Route::post('billing-details',[BillingController::class,'billing_details']);


Route::post('paypal',[PaypalController::class,'payWithPaypal'])->name('paypal');
Route::match(['get', 'post'], '/paypal/status', [PaypalController::class, 'getPaymentStatus'])->name('api.paypal.status');
