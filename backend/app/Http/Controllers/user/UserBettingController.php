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
                'bet_id' => 'required|string',
                'sport_key' => 'required|string',
                'sport' => 'required|string',
                'sport_title' => 'required|string',
                'commence_time' => 'required|date',
                'home_team' => 'required|string',
                'away_team' => 'required|string',
                'bookmaker_key' => 'required|string',
                'bookmaker_title' => 'required|string',
                'straight_bets' => 'required|array',
                'parlay_bets' => 'required|array',
                'total_collect' => 'required|array'
            ]);

            // ✅ Convert `commence_time` to MySQL format
            $validated['commence_time'] = \Carbon\Carbon::parse($validated['commence_time'])->format('Y-m-d H:i:s');

            $userId = $validated['user_id'];
            $sport = $validated['sport']; // ✅ Extract correct sport value


            // Save Straight Bets
            foreach ($validated['straight_bets'] as $bet) {

                $total_collect = $bet['pick'] + $bet['toWin'];

                Betting::create([
                    'bet_id' => $validated['bet_id'],
                    'sport_key' => $validated['sport_key'],
                    'sport' => $sport, // ✅ Store correct sport value
                    'sport_title' => $validated['sport_title'],
                    'commence_time' => $validated['commence_time'],
                    'home_team' => $validated['home_team'],
                    'away_team' => $validated['away_team'],
                    'bookmaker_key' => $validated['bookmaker_key'],
                    'bookmaker_title' => $validated['bookmaker_title'],
                    'user_id' => $userId,
                    'type' => $bet['type'],
                    'team' => $bet['team'] ?? null,
                    'price' => $bet['price'], // ✅ Store correct price value
                    'pick' => $bet['pick'] ?? 0,
                    'to_win' => $bet['toWin'] ?? 0,
                    'bet_type' => 'straight',
                    'total_collect' => $total_collect ?? 0
                ]);
            }

            // Save Parlay Bets
            foreach ($validated['parlay_bets'] as $bet) {

                $total_collect = $bet['pick'] + $bet['toWin'];

                Betting::create([
                    'bet_id' => $validated['bet_id'],
                    'sport_key' => $validated['sport_key'],
                    'sport' => $sport, // ✅ Store correct sport value
                    'sport_title' => $validated['sport_title'],
                    'commence_time' => $validated['commence_time'],
                    'home_team' => $validated['home_team'],
                    'away_team' => $validated['away_team'],
                    'bookmaker_key' => $validated['bookmaker_key'],
                    'bookmaker_title' => $validated['bookmaker_title'],
                    'user_id' => $userId,
                    'type' => $bet['type'],
                    'team' => $bet['team'] ?? null,
                    'pick' => $bet['pick'] ?? 0,
                    'price' => $bet['price'], // ✅ Store correct price value
                    'to_win' => $bet['toWin'] ?? 0,
                    'bet_type' => 'parlay',
                    'total_collect' => $total_collect ?? 0
                ]);
            }

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
