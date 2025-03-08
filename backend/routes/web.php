<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\user\UserSportController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('test',[AdminController::class,'test']);

Route::get('/',[AdminController::class,'test1']);

Route::get('sport-details',[UserSportController::class,'sport_details']);
Route::get('score',[UserSportController::class,'scores']);


// ********************************* Admin Dashboard ***************************************

Route::get('user-details',[AdminAuthController::class,'user_details']);




// ********************************** User Dashboard ****************************************


Route::get('american-football',[UserSportController::class,'american_football_odds']);
Route::get('basketball',[UserSportController::class,'basketball_odds']);