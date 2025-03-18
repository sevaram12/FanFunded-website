<?php

namespace App\Http\Controllers;

use App\Models\Betting;
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

        // API Configuration
        $apiKey = "4925b641625b8a1205cf6c624ec43fc1";
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
                return view('user.my_picks', compact('bettings'))->with('fail', "No scores found for any sports.");
            }


            // Pass data to Blade view
            return view('user.my_picks', compact('bettings', 'allScores'));
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

        // API Configuration
        $apiKey = "4925b641625b8a1205cf6c624ec43fc1";
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

            // Pass data to Blade view
            return view('user.account_overview', compact('bettings', 'allScores'));
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }
}
