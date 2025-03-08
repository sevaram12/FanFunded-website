<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSportController extends Controller
{
    public function sport_details()
    {
        try {

            $curl = curl_init();

            $apiUrl = "https://api.the-odds-api.com/v4/sports/?apiKey=a607ecbc3eb6420427d92365d46043ee";

            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
            }

            $responseData = json_decode($response, true);

            if (empty($responseData)) {
                return response()->json(['error' => 'No data returned from The Odds API.'], 500);
            }

            $sportData = $responseData;

           return view('user.sport.sport_details',compact('sportData'));

        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['error' => 'An error occurred: ' . $sortmessage], 500);
        }
    }




    public function american_football_odds(Request $request)
    {
        try {
            $sport = $request->input('sport');

            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }

            // API keys
            $apiKeyOdds = "a607ecbc3eb6420427d92365d46043ee";  // API key for odds
            // $apiKeySports = "a607ecbc3eb6420427d92365d46043ee";  // API key for sports

            // API URLs
            $regions = $request->input('regions', 'us');
            $markets = $request->input('markets', 'h2h,totals,spreads');
            $oddsFormat = $request->input('oddsFormat', 'american');

            $apiUrlOdds = "https://api.the-odds-api.com/v4/sports/{$sport}/odds/?apiKey={$apiKeyOdds}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}";

            $apiUrlSports = "https://api.the-odds-api.com/v4/sports/?apiKey={$apiKeyOdds}";

            // Initialize cURL multi-request
            $multiCurl = curl_multi_init();
            $curlHandles = [];

            // Create cURL handles for each API
            $urls = [
                'odds' => $apiUrlOdds,
                'sports' => $apiUrlSports
            ];

            foreach ($urls as $key => $url) {
                $curlHandles[$key] = curl_init();
                curl_setopt_array($curlHandles[$key], [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);
                curl_multi_add_handle($multiCurl, $curlHandles[$key]);
            }

            // Execute all requests simultaneously
            $running = null;
            do {
                curl_multi_exec($multiCurl, $running);
            } while ($running);

            // Get responses
            $oddsData = $sportData = null;
            foreach ($curlHandles as $key => $curl) {
                $response = curl_multi_getcontent($curl);
                $error = curl_error($curl);
                curl_multi_remove_handle($multiCurl, $curl);
                curl_close($curl);

                if ($error) {
                    // Log::error("cURL error for {$key}: {$error}");
                    return redirect('user.sport.american-football')->with('fail', 'Error not fetching data.');
                    // return response()->json(['error' => "Error fetching {$key} data."], 500);
                }

                $decodedResponse = json_decode($response, true);

                if ($key === 'odds') {
                    $oddsData = $decodedResponse;
                } elseif ($key === 'sports') {
                    $sportData = $decodedResponse;
                }
            }

            // Close multi-cURL
            curl_multi_close($multiCurl);

            // Log API responses
            Log::info('Odds API response:', ['data' => $oddsData]);
            Log::info('Sports API response:', ['data' => $sportData]);

            // dd($oddsData);
            // Return view with combined data
            return view('user.sport.american-football', compact('oddsData', 'sportData'));
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return redirect('user.sport.american-football')->with('fail', 'An error occured: ' . $sortmessage);
        }
    }



    public function basketball_odds(Request $request)
    {
        try {
            $sport = $request->input('sport');

            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }

            // API keys
            $apiKeyOdds = "a607ecbc3eb6420427d92365d46043ee";  // API key for odds
            // $apiKeySports = "a607ecbc3eb6420427d92365d46043ee";  // API key for sports

            // API URLs
            $regions = $request->input('regions', 'us');
            $markets = $request->input('markets', 'h2h,totals,spreads');
            $oddsFormat = $request->input('oddsFormat', 'american');

            $apiUrlOdds = "https://api.the-odds-api.com/v4/sports/{$sport}/odds/?apiKey={$apiKeyOdds}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}";

            $apiUrlSports = "https://api.the-odds-api.com/v4/sports/?apiKey={$apiKeyOdds}";

            // Initialize cURL multi-request
            $multiCurl = curl_multi_init();
            $curlHandles = [];

            // Create cURL handles for each API
            $urls = [
                'odds' => $apiUrlOdds,
                'sports' => $apiUrlSports
            ];

            foreach ($urls as $key => $url) {
                $curlHandles[$key] = curl_init();
                curl_setopt_array($curlHandles[$key], [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);
                curl_multi_add_handle($multiCurl, $curlHandles[$key]);
            }

            // Execute all requests simultaneously
            $running = null;
            do {
                curl_multi_exec($multiCurl, $running);
            } while ($running);

            // Get responses
            $oddsData = $sportData = null;
            foreach ($curlHandles as $key => $curl) {
                $response = curl_multi_getcontent($curl);
                $error = curl_error($curl);
                curl_multi_remove_handle($multiCurl, $curl);
                curl_close($curl);

                if ($error) {
                    // Log::error("cURL error for {$key}: {$error}");
                    return redirect('user.sport.basketball')->with('fail', 'Error not fetching data.');
                    // return response()->json(['error' => "Error fetching {$key} data."], 500);
                }

                $decodedResponse = json_decode($response, true);

                if ($key === 'odds') {
                    $oddsData = $decodedResponse;
                } elseif ($key === 'sports') {
                    $sportData = $decodedResponse;
                }
            }

            // Close multi-cURL
            curl_multi_close($multiCurl);

            // dd($sportData);
            // Log API responses
            Log::info('Odds API response:', ['data' => $oddsData]);
            Log::info('Sports API response:', ['data' => $sportData]);

            //    dd($oddsData);
            // Return view with combined data
            return view('user.sport.basketball', compact('oddsData', 'sportData'));
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return redirect('user.sport.basketball')->with('fail', 'An error occured: ' . $sortmessage);
        }
    }



    public function mma_odds(Request $request)
    {
        try {
            $sport = $request->input('sport');

            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }

            // API keys
            $apiKeyOdds = "a607ecbc3eb6420427d92365d46043ee";  // API key for odds
            // $apiKeySports = "a607ecbc3eb6420427d92365d46043ee";  // API key for sports

            // API URLs
            $regions = $request->input('regions', 'us');
            $markets = $request->input('markets', 'h2h,totals,spreads');
            $oddsFormat = $request->input('oddsFormat', 'american');

            $apiUrlOdds = "https://api.the-odds-api.com/v4/sports/{$sport}/odds/?apiKey={$apiKeyOdds}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}";

            $apiUrlSports = "https://api.the-odds-api.com/v4/sports/?apiKey={$apiKeyOdds}";

            // Initialize cURL multi-request
            $multiCurl = curl_multi_init();
            $curlHandles = [];

            // Create cURL handles for each API
            $urls = [
                'odds' => $apiUrlOdds,
                'sports' => $apiUrlSports
            ];

            foreach ($urls as $key => $url) {
                $curlHandles[$key] = curl_init();
                curl_setopt_array($curlHandles[$key], [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ],
                ]);
                curl_multi_add_handle($multiCurl, $curlHandles[$key]);
            }

            // Execute all requests simultaneously
            $running = null;
            do {
                curl_multi_exec($multiCurl, $running);
            } while ($running);

            // Get responses
            $oddsData = $sportData = null;
            foreach ($curlHandles as $key => $curl) {
                $response = curl_multi_getcontent($curl);
                $error = curl_error($curl);
                curl_multi_remove_handle($multiCurl, $curl);
                curl_close($curl);

                if ($error) {
                    // Log::error("cURL error for {$key}: {$error}");
                    return redirect('user.sport.mma')->with('fail', 'Error not fetching data.');
                    // return response()->json(['error' => "Error fetching {$key} data."], 500);
                }

                $decodedResponse = json_decode($response, true);

                if ($key === 'odds') {
                    $oddsData = $decodedResponse;
                } elseif ($key === 'sports') {
                    $sportData = $decodedResponse;
                }
            }

            // Close multi-cURL
            curl_multi_close($multiCurl);

            // dd($sportData);
            // Log API responses
            Log::info('Odds API response:', ['data' => $oddsData]);
            Log::info('Sports API response:', ['data' => $sportData]);

            //    dd($oddsData);
            // Return view with combined data
            return view('user.sport.mma', compact('oddsData', 'sportData'));
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return redirect('user.sport.mma')->with('fail', 'An error occured: ' . $sortmessage);
        }
    }




    public function scores(Request $request)
    {
        try {
            $apiKey = "a607ecbc3eb6420427d92365d46043ee";
            $daysFrom = $request->input('daysFrom', 1);

            $apiUrl = "https://api.the-odds-api.com/v4/sports/basketball_nba/scores/?daysFrom={$daysFrom}&apiKey={$apiKey}";

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($err) {
                Log::error("cURL error: {$err}");
                return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
            }

            Log::info('The Odds API Response:', ['response' => $response, 'status_code' => $statusCode]);

            $responseData = json_decode($response, true);

            if ($responseData === null) {
                return redirect('score')->with('fail', 'The API returned an invalid response.');
            }

            // Log::info('API response data:', ['response_data' => $responseData]);

            $scoreData = $responseData;

            if (empty($responseData)) {

                return redirect('score')->with('fail', 'No scores found for the requested NBA games.');
            }


            return view('user.partial.header', compact('scoreData'));
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }
}
