<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Betting;
use App\Models\PaypalPayment;
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

        $validated['commence_time'] = \Carbon\Carbon::parse($validated['commence_time'])->format('Y-m-d H:i:s');

        $userId = $validated['user_id'];
        $sport = $validated['sport'];

        $payment = PaypalPayment::where('user_id', $request->user_id)
            ->where('challenge_status', 'Active')
            ->first();

        if (!$payment) {
            return response()->json(['status' => false, 'message' => 'No active challenge found for this user.'], 400);
        }

        if ($payment->end_date < now()) {
            return response()->json(['status' => false, 'message' => 'Your challenge time is over.'], 400);
        }

        foreach ($validated['straight_bets'] as $bet) {
            $pickAmount = $bet['pick'] ?? 0;
            $toWin = $bet['toWin'] ?? 0;
            $totalCollect = $pickAmount + $toWin;

            if ($payment->minimum_picks > $pickAmount) {
                return response()->json(['status' => false, 'message' => 'Minimum pick amount is ' . $payment->minimum_picks], 400);
            }

            if ($payment->minimum_picks_amount > $toWin) {
                return response()->json(['status' => false, 'message' => 'Minimum pick amount is ' . $payment->minimum_picks_amount], 400);
            }

            if ($payment->maximum_picks_amount < $toWin) {
                return response()->json(['status' => false, 'message' => 'Maximum pick amount is ' . $payment->maximum_picks_amount], 400);
            }

            if ($payment->your_balance < $pickAmount) {
                return response()->json(['status' => false, 'message' => 'Insufficient amount in your wallet.'], 400);
            }

            $payment->your_balance -= $pickAmount;
            $payment->save();

            Betting::create([
                'bet_id' => $validated['bet_id'],
                'sport_key' => $validated['sport_key'],
                'sport' => $sport,
                'sport_title' => $validated['sport_title'],
                'commence_time' => $validated['commence_time'],
                'home_team' => $validated['home_team'],
                'away_team' => $validated['away_team'],
                'bookmaker_key' => $validated['bookmaker_key'],
                'bookmaker_title' => $validated['bookmaker_title'],
                'user_id' => $userId,
                'type' => $bet['type'],
                'team' => $bet['team'] ?? null,
                'your_bet_team' => $bet['team'] ?? null,
                'price' => $bet['price'] ?? 0,
                'pick' => $pickAmount,
                'to_win' => $toWin,
                'bet_type' => 'straight',
                'total_collect' => $totalCollect
            ]);
        }

        foreach ($validated['parlay_bets'] as $bet) {
            $pickAmount = $bet['pick'] ?? 0;
            $toWin = $bet['toWin'] ?? 0;
            $totalCollect = $pickAmount + $toWin;

            if ($payment->minimum_picks > $pickAmount) {
                return response()->json(['status' => false, 'message' => 'Minimum pick amount is ' . $payment->minimum_picks], 400);
            }

            if ($payment->minimum_picks_amount > $toWin) {
                return response()->json(['status' => false, 'message' => 'Minimum pick amount is ' . $payment->minimum_picks_amount], 400);
            }

            if ($payment->maximum_picks_amount < $toWin) {
                return response()->json(['status' => false, 'message' => 'Maximum pick amount is ' . $payment->maximum_picks_amount], 400);
            }

            if ($payment->your_balance < $pickAmount) {
                return response()->json(['status' => false, 'message' => 'Insufficient amount in your wallet.'], 400);
            }

            $payment->your_balance -= $pickAmount;
            $payment->save();

            Betting::create([
                'bet_id' => $validated['bet_id'],
                'sport_key' => $validated['sport_key'],
                'sport' => $sport,
                'sport_title' => $validated['sport_title'],
                'commence_time' => $validated['commence_time'],
                'home_team' => $validated['home_team'],
                'away_team' => $validated['away_team'],
                'bookmaker_key' => $validated['bookmaker_key'],
                'bookmaker_title' => $validated['bookmaker_title'],
                'user_id' => $userId,
                'type' => $bet['type'],
                'team' => $bet['team'] ?? null,
                'your_bet_team' => $bet['team'] ?? null,
                'pick' => $pickAmount,
                'price' => $bet['price'] ?? 0,
                'to_win' => $toWin,
                'bet_type' => 'parlay',
                'total_collect' => $totalCollect
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Pickslip stored successfully.']);
    } catch (\Exception $e) {
        Log::error('Error storing pickslip:', ['message' => $e->getMessage()]);
        return response()->json(['status' => false, 'message' => 'An error occurred while placing the bet.'], 500);
    }
}
  
    




    public function cashout($id){
        
        $betting = Betting::find($id);

        $payment = PaypalPayment::where('user_id',$betting->user_id)->first();
        $betting->match_status = 'Cashed Out';

        $payment->your_balance = $payment->your_balance + $betting->pick;
        $payment->save();
        $betting->save();


        return redirect()->back()->with('success','Cashedout Successfully!!');
    }




    // public function pickhistory()
    // {
    //     // Fetch all betting records with user details
    //     $pickslips = Betting::with('user')->orderBy('created_at', 'desc')->get();
    
    //     if ($pickslips->isEmpty()) {
    //         return view('user.sport.my_picks', ['winningDetails' => [], 'losingDetails' => []]);
    //     }
    
    //     // Separate winning and losing bets
    //     $winningDetails = [];
    //     $losingDetails = [];
    
    //     foreach ($pickslips as $pickslip) {
    //         $betData = [
    //             'user' => optional($pickslip->user)->name,
    //             'created_at' => $pickslip->created_at,
    //             'game' => $pickslip->game ?: '',
    //             'bet_type' => $pickslip->bet_type ?: '',
    //             'team' => $pickslip->team ?: '',
    //             'spread' => $pickslip->spread ?: '',
    //             'odds' => $pickslip->odds ?: '',
    //             'total_pick' => $pickslip->total_pick ?: 0,
    //             'payout' => $pickslip->payout ?: 0,
    //             'pick_id' => $pickslip->pick_id ?: '',
    //             'straight_bets' => json_decode($pickslip->straight_bets, true) ?? [],
    //             'parlay_bets' => json_decode($pickslip->parlay_bets, true) ?? [],
    //             'total_collect' => json_decode($pickslip->total_collect, true) ?? ['straight' => 0, 'parlay' => 0],
    //             'status' => $pickslip->status // Assuming you have a 'status' column for Win/Loss
    //         ];
    
    //         if ($pickslip->status === 'win') {
    //             $winningDetails[] = $betData;
    //         } else {
    //             $losingDetails[] = $betData;
    //         }
    //     }
    
    //     return view('user.sport.my_picks', compact('winningDetails', 'losingDetails'));
    // }
    


    // public function winning_delails()
    // {
    //     // Fetch all betting records with user details
    //     $pickslips = Betting::with('user')->orderBy('created_at', 'desc')->get();
    
    //     // Default values to prevent errors
    //     if ($pickslips->isEmpty()) {
    //         return view('user.sport.winning-delails', [
    //             'winningDetails' => [],
    //             'currentBalance' => 0,  
    //             'totalPicks' => 0,  
    //             'highestWinningPick' => 0, 
    //             'picksWon' => 0,
    //             'picksLoss' => 0,
    //         ]);
    //     }
    
    //     // Mapping bet details
    //     $winningDetails = $pickslips->map(function ($pickslip) {
    //         return [
    //             'user' => optional($pickslip->user)->name,
    //             'created_at' => $pickslip->created_at,
    //             'game' => $pickslip->game ?: '',
    //             'bet_type' => $pickslip->bet_type ?: '',
    //             'team' => $pickslip->team ?: '',
    //             'spread' => $pickslip->spread ?: '',
    //             'odds' => $pickslip->odds ?: '',
    //             'total_pick' => $pickslip->total_pick ?: 0,
    //             'payout' => $pickslip->payout ?: 0,
    //             'pick_id' => $pickslip->pick_id ?: '',
    //             'straight_bets' => json_decode($pickslip->straight_bets, true) ?? [],
    //             'parlay_bets' => json_decode($pickslip->parlay_bets, true) ?? [],
    //             'total_collect' => json_decode($pickslip->total_collect, true) ?? ['straight' => 0, 'parlay' => 0],
    //             'status' => $pickslip->status ?? 'lost'
    //         ];
    //     });
    
    //     // **Calculations**
    //     $currentBalance = $pickslips->sum('payout'); // Total earnings
    //     $totalPicks = $pickslips->count(); // Total number of picks
    //     $highestWinningPick = $pickslips->max('payout'); // Highest payout among all bets
    
    //     // **Counting Wins/Losses**
    //     $picksWon = $pickslips->where('status', 'won')->count();
    //     $picksLoss = $pickslips->where('status', 'lost')->count();
    
    //     return view('user.sport.winning-delails', compact(
    //         'winningDetails',
    //         'currentBalance',
    //         'totalPicks',
    //         'highestWinningPick',
    //         'picksWon',
    //         'picksLoss'
    //     ));
    // }
    
    



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
