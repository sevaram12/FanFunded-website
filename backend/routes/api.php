<?php

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


//---------------------------------------------sports--------------------------------------------------------------//

Route::get('/sports', [SportController::class, 'sports']);
Route::get('/odds', [SportController::class, 'odds']);
Route::get('/scores', [SportController::class, 'scores']);
Route::get('/events', [SportController::class, 'events']);


