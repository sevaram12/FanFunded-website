<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\user\auth\UserAuthController;
use App\Http\Controllers\user\UserBettingController;
use App\Http\Controllers\user\UserSportController;
use App\Http\Controllers\UserController;
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

Route::get('test1',[AdminController::class,'test1']);

Route::get('sport-details',[UserSportController::class,'sport_details']);
Route::get('score',[UserSportController::class,'scores']);


// ******************************** Admin Dashboard **************************************

Route::get('user-details',[AdminAuthController::class,'user_details']);

Route::get('pick-history', [AdminController::class, 'pick_history']);

Route::get('signup',[AdminAuthController::class,'sign_up']);
Route::post('signup',[AdminAuthController::class,'register']);
Route::get('/',[AdminAuthController::class,'login']);
Route::post('login',[AdminAuthController::class,'admin_login']);



// ********************************** User Dashboard ****************************************

Route::get('logout',[UserAuthController::class,'logout']);
Route::get('my-picks',[UserController::class,'my_picks']);
Route::get('account-overview',[UserController::class,'account_overview']);
Route::get('american-football',[UserSportController::class,'american_football_odds']);
Route::get('basketball',[UserSportController::class,'basketball_odds']);
Route::get('baseball', [UserSportController::class, 'baseball_odds']);
Route::get('mma',[UserSportController::class,'mma_odds']);
Route::get('icehockey', [UserSportController::class, 'icehockey_odds']);
Route::get('soccer', [UserSportController::class, 'soccer_odds']);
Route::get('tennis', [UserSportController::class, 'tennis_odds']);
Route::get('golf', [UserSportController::class, 'golf_odds']);
Route::post('store-baseball-pickslip', [UserBettingController::class, 'store'])->name('store.baseball.pickslip');
Route::post('store-basketball-pickslip', [UserBettingController::class, 'store'])->name('store.basketball.pickslip');
Route::post('store-golf-pickslip', [UserBettingController::class, 'store'])->name('store.golf.pickslip');
Route::post('store-icehockey-pickslip', [UserBettingController::class, 'store'])->name('store.icehockey.pickslip');
Route::post('store-mma-pickslip', [UserBettingController::class, 'store'])->name('store.mma.pickslip');
Route::post('store-soccer-pickslip', [UserBettingController::class, 'store'])->name('store.soccer.pickslip');
Route::post('store-tennis-pickslip', [UserBettingController::class, 'store'])->name('store.tennis.pickslip');
Route::post('store-football-pickslip', [UserBettingController::class, 'store'])->name('store.football.pickslip');

Route::get('winning-delails', [UserBettingController::class, 'winning_delails']);

Route::get('my_picks', [UserBettingController::class, 'pickhistory']);
Route::get('cashout/{id}',[UserBettingController::class,'cashout']);

