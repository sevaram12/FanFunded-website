<?php

namespace App\Http\Controllers;

use App\Models\Betting;
use App\Models\PaypalPayment;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{

    public function my_picks(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        $user_id = session()->get('user_id');

        // Fetch user's betting data
        $bettings = Betting::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        
        $payment = PaypalPayment::where('user_id',$user_id)->where('challenge_status','Active')->first();

        $your_balance = $payment->your_balance;

        // API Configuration

        $apiKey = "34ccb3c0d93144a6a6afc32a5eb77a8a";

        $daysFrom = $request->input('daysFrom', 3);
        $dateFormat = "iso";

        try {
            // Step 1: Fetch all sports
            $sportsApiUrl = "https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $sportsApiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $sportsResponse = curl_exec($curl);
            curl_close($curl);

            if (!$sportsResponse) {
                return response()->json(['error' => 'Error fetching sports list from The Odds API.'], 500);
            }

            $sportsData = json_decode($sportsResponse, true);

            if (empty($sportsData)) {
                return response()->json(['error' => 'No sports data found.'], 500);
            }

            // Extract all sport keys
            $sportKeys = array_column($sportsData, 'key');

            // Step 2: Fetch scores for all sports **simultaneously**
            $multiCurl = curl_multi_init();
            $curlHandles = [];
            $allScores = [];

            foreach ($sportKeys as $sport) {
                $scoresApiUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/scores/?apiKey={$apiKey}&daysFrom={$daysFrom}&dateFormat={$dateFormat}";

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $scoresApiUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 10, // Reduce timeout
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);

                curl_multi_add_handle($multiCurl, $ch);
                $curlHandles[$sport] = $ch;
            }

            // Execute all requests in parallel
            do {
                $status = curl_multi_exec($multiCurl, $active);
            } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

            // Get responses
            foreach ($curlHandles as $sport => $ch) {
                $scoresResponse = curl_multi_getcontent($ch);
                curl_multi_remove_handle($multiCurl, $ch);
                curl_close($ch);

                if ($scoresResponse) {
                    $scores = json_decode($scoresResponse, true);
                    if (!empty($scores)) {
                        $allScores[$sport] = $scores;
                    }
                }
            }

            curl_multi_close($multiCurl);

            // If no scores were found, return view with error message
            if (empty($allScores)) {
                return view('user.my_picks', compact('bettings'))->with('fail', "No scores found for any sports.");
            }

            // ✅ Process and update match status for each bet
            foreach ($bettings as $bet) {
                // Flatten scores data
                $flattenedScores = collect($allScores)->flatMap(fn($sport) => $sport);

                // Find matching game
                $matchingScore = $flattenedScores->firstWhere('id', $bet->bet_id);

                // Default match status
                // $matchStatus = "Active";

                if ($matchingScore && isset($matchingScore['completed']) && $matchingScore['completed']) {
                    if (isset($matchingScore['scores']) && count($matchingScore['scores']) === 2) {
                        $team1 = $matchingScore['scores'][0];
                        $team2 = $matchingScore['scores'][1];

                        // Determine which team won
                        $winningTeam = ($team1['score'] > $team2['score']) ? $team1['name'] : $team2['name'];

                        // Set match status based on user's bet team
                        $matchStatus = ($winningTeam === $bet->your_bet_team) ? "Won" : "Lost";
                        $bet->match_status = $matchStatus;
                        $bet->save(); // ✅ Force save
                        // dd($matchStatus);
                    }
                }

                


                // ✅ Save or update the match_status in the database

            }

        $no_of_pick = Betting::where('user_id',$user_id)->count(); // total bets of user

        $pick_won = Betting::where('user_id',$user_id)->where('match_status','won')->count(); // count of user won pick

        $pick_loss = Betting::where('user_id',$user_id)->where('match_status','lost')->count(); // count of user won pick

        // dd($pick_won);

        $win_rate = round(($pick_won / $no_of_pick) * 100, 2); // user winning percentage 

        $loss_rate = round(($pick_loss/$no_of_pick) * 100 ,2);

        // ✅ Find the Highest Winning Pick
        $highestWinningPick = Betting::where('user_id', $user_id)
                            ->where('match_status', 'Won')
                            ->orderByDesc('total_collect')
                            ->first();
        
        // ✅ Calculate Total Bet Amount
        $totalBetAmount = Betting::where('user_id', $user_id)->sum('pick');

        // ✅ Calculate Highest Winning Pick Percentage
        $highestWinningPickPercentage = ($highestWinningPick && $totalBetAmount > 0) 
                                        ? round(($highestWinningPick->total_collect / $totalBetAmount) * 100, 2) 
                                        : 0;

        // ✅ Calculate Total Profit (sum of (total_collect - pick))
        $totalProfit = Betting::where('user_id', $user_id)
                        ->selectRaw('SUM(total_collect - pick) as profit')
                        ->value('profit');

        
        // ✅ Calculate Average Profit Per Pick ($)
        $averageProfitPerPickDollar = ($no_of_pick > 0) 
                                ? round(($totalProfit / $no_of_pick), 2) 
                                : 0;

            // Pass data to Blade view
            return view('user.my_picks', compact('bettings', 'allScores','no_of_pick','pick_won','pick_loss','win_rate','loss_rate','highestWinningPickPercentage','averageProfitPerPickDollar','your_balance'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }




    public function account_overview(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        $user_id = session()->get('user_id');

        // Fetch user's betting data
        $bettings = Betting::where('user_id', $user_id)->orderBy('id', 'desc')->get();

        $payment = PaypalPayment::where('user_id',$user_id)->where('challenge_status','Active')->first();

        $your_balance = $payment->your_balance;
        // API Configuration

        $apiKey = "34ccb3c0d93144a6a6afc32a5eb77a8a";

        $daysFrom = $request->input('daysFrom', 3);
        $dateFormat = "iso";

        try {
            // Step 1: Fetch all sports
            $sportsApiUrl = "https://api.the-odds-api.com/v4/sports/?apiKey={$apiKey}";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $sportsApiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10, // Reduce timeout
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $sportsResponse = curl_exec($curl);
            curl_close($curl);

            if (!$sportsResponse) {
                return response()->json(['error' => 'Error fetching sports list from The Odds API.'], 500);
            }

            $sportsData = json_decode($sportsResponse, true);

            if (empty($sportsData)) {
                return response()->json(['error' => 'No sports data found.'], 500);
            }

            // Extract all sport keys
            $sportKeys = array_column($sportsData, 'key');

            // Step 2: Fetch scores for all sports **simultaneously**
            $multiCurl = curl_multi_init();
            $curlHandles = [];
            $allScores = [];

            foreach ($sportKeys as $sport) {
                $scoresApiUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/scores/?apiKey={$apiKey}&daysFrom={$daysFrom}&dateFormat={$dateFormat}";

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $scoresApiUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 10, // Reduce timeout
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);

                curl_multi_add_handle($multiCurl, $ch);
                $curlHandles[$sport] = $ch;
            }

            // Execute all requests in parallel
            do {
                $status = curl_multi_exec($multiCurl, $active);
            } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

            // Get responses
            foreach ($curlHandles as $sport => $ch) {
                $scoresResponse = curl_multi_getcontent($ch);
                curl_multi_remove_handle($multiCurl, $ch);
                curl_close($ch);

                if ($scoresResponse) {
                    $scores = json_decode($scoresResponse, true);
                    if (!empty($scores)) {
                        $allScores[$sport] = $scores;
                    }
                }
            }

            curl_multi_close($multiCurl);

            if (empty($allScores)) {
                return view('user.account_overview', compact('bettings'))->with('fail', "No scores found for any sports.");
            }

            // ✅ Process and update match status for each bet
            foreach ($bettings as $bet) {
                // Flatten scores data
                $flattenedScores = collect($allScores)->flatMap(fn($sport) => $sport);

                // Find matching game
                $matchingScore = $flattenedScores->firstWhere('id', $bet->bet_id);

                // Default match status
                // $matchStatus = "Active";

                if ($matchingScore && isset($matchingScore['completed']) && $matchingScore['completed']) {
                    if (isset($matchingScore['scores']) && count($matchingScore['scores']) === 2) {
                        $team1 = $matchingScore['scores'][0];
                        $team2 = $matchingScore['scores'][1];

                        // Determine which team won
                        $winningTeam = ($team1['score'] > $team2['score']) ? $team1['name'] : $team2['name'];

                        // Set match status based on user's bet team
                        $matchStatus = ($winningTeam === $bet->your_bet_team) ? "Won" : "Lost";
                        // ✅ Save match_status in the database
                        $bet->match_status = $matchStatus;
                        $bet->save();
                    }
                }

                
            }

            // Pass data to Blade view
            return view('user.account_overview', compact('bettings', 'allScores','your_balance'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }
}
