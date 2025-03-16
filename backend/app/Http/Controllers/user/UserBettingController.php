<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Betting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserBettingController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Pickslip Request:', $request->all());

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'straight_bets' => 'required|array',
                'parlay_bets' => 'required|array',
                'total_collect' => 'required|array'
            ]);

            $pickslip = new Betting();
            $pickslip->user_id = $validated['user_id'];
            $pickslip->straight_bets = json_encode($validated['straight_bets']);
            $pickslip->parlay_bets = json_encode($validated['parlay_bets']);
            $pickslip->total_collect = json_encode($validated['total_collect']);
            $pickslip->save();

            return response()->json(['success' => true, 'message' => 'Pickslip stored successfully']);
        } catch (\Exception $e) {
            Log::error('Error storing pickslip:', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }



    // public function store(Request $request)
    //     {
    //         try {
    //             Log::info('Pickslip Request:', $request->all());

    //             // ✅ Validate input data
    //             $validated = $request->validate([
    //                 'user_id' => 'required|exists:users,id',
    //                 'straight_bets' => 'required|array',
    //                 'parlay_bets' => 'required|array',
    //                 'total_collect' => 'required|array'
    //             ]);

    //             $pickslip = new Betting();
    //             $pickslip->user_id = $validated['user_id'];
    //             $pickslip->straight_bets = json_encode($validated['straight_bets']);
    //             $pickslip->parlay_bets = json_encode($validated['parlay_bets']);
    //             $pickslip->total_collect = json_encode($validated['total_collect']);
    //             $pickslip->save();

    //             foreach (array_merge($validated['straight_bets'], $validated['parlay_bets']) as $bet) {
    //                 Betting::create([
    //                     'user_id' => $validated['user_id'],
    //                     'bet_type' => $bet['type'],
    //                     'team' => $bet['team'],
    //                     'pick' => $bet['pick'],
    //                     'to_win' => $bet['toWin'],
    //                     'match_id' => $bet['id'] ?? null,
    //                     'sport_title' => $bet['sport_title'] ?? null,
    //                     'commence_time' => $bet['commence_time'] ?? null,
    //                     'home_team' => $bet['home_team'] ?? null,
    //                     'away_team' => $bet['away_team'] ?? null,
    //                     'key' => $bet['key'] ?? null,
    //                     'price' => $bet['price'] ?? null
    //                 ]);
    //             }

    //             return response()->json(['success' => true, 'message' => 'Pickslip stored successfully']);
    //         } catch (\Exception $e) {
    //             Log::error('Error storing pickslip:', ['message' => $e->getMessage()]);
    //             return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //         }
    //     }
}
