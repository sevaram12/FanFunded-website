<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SportController extends Controller
{

    //----------------------------------------------------- sports -----------------------------------------------//

    public function sports()
    {
        try {

            $curl = curl_init();

            $apiUrl = "https://api.the-odds-api.com/v4/sports/?apiKey=cc95846b25e260612e379b29b82cfaaa";

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

            return response()->json([
                'error' => false,
                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['error' => 'An error occurred: ' . $sortmessage], 500);
        }
    }

    //--------------------------------------------------------odds ------------------------------------------------//

    public function odds(Request $request)
    {
        try {
            $sport = $request->input('sport');

            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }

            $apiKey = "6d37b47f19cd9291c267b58924f029de";
            $regions = $request->input('regions');
            $markets = $request->input('markets');
            $oddsFormat = $request->input('oddsFormat');

            $apiUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/odds/?apiKey={$apiKey}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}";

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

            Log::info('API response data:', ['response_data' => $responseData]);

            $oddsData = [];
            foreach ($responseData as $event) {
                $oddsData[] = [
                    'id' => $event['id'],
                    'sport_key' => $event['sport_key'],
                    'sport_title' => $event['sport_title'],
                    'commence_time' => $event['commence_time'],
                    'home_team' => $event['home_team'],
                    'away_team' => $event['away_team'],
                    'bookmakers' => $event['bookmakers'],
                ];
            }

            return response()->json([
                'error' => false,
                'data' => $oddsData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //-------------------------------------------------------scores ------------------------------------------------//

    public function scores(Request $request)
    {
        try {
            $apiKey = "6d37b47f19cd9291c267b58924f029de";
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
                Log::error('Invalid JSON response from the API:', ['response' => $response]);
                return response()->json(['error' => 'The API returned an invalid response.'], 500);
            }

            Log::info('API response data:', ['response_data' => $responseData]);

            if (empty($responseData)) {
                return response()->json([
                    'error' => "No scores found for the requested NBA games."
                ], 404);
            }

            return response()->json([
                'error' => false,
                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //--------------------------------------------------------events ------------------------------------------------//

    public function events(Request $request)
    {
        try {

            $apiKey = "6d37b47f19cd9291c267b58924f029de";

            $sportKey = $request->input('sport_key');
            $events = $request->input('events');
            $daysFrom = $request->input('daysFrom', 1);

            $apiUrl = "https://api.the-odds-api.com/v4/sports/{$sportKey}/events?apiKey={$apiKey}&daysFrom={$daysFrom}";

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
                Log::error('Invalid JSON response from the API:', ['response' => $response]);
                return response()->json(['error' => 'The API returned an invalid response.'], 500);
            }

            Log::info('API response data:', ['response_data' => $responseData]);

            if (empty($responseData)) {
                return response()->json([
                    'error' => "No events found for the requested sport ({$events})."
                ], 404);
            }

            return response()->json([
                'error' => false,
                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //--------------------------------------------------------getEventOdds ------------------------------------------------//

    public function getEventOdds(Request $request)
    {
        try {
            $apiKey = "6d37b47f19cd9291c267b58924f029de";
            $sport = $request->input('sport');
            $eventId = $request->input('eventId');

            if (!$sport || !$eventId) {
                return response()->json(['error' => 'Sport and Event ID are required.'], 400);
            }

            $oddsUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/events/{$eventId}/odds?apiKey={$apiKey}&regions=us&markets=player_pass_tds&oddsFormat=american";

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $oddsUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
            ]);

            $oddsResponse = curl_exec($curl);
            $oddsErr = curl_error($curl);
            curl_close($curl);

            if ($oddsErr) {
                return response()->json(['error' => 'Error fetching odds from The Odds API.'], 500);
            }

            $oddsData = json_decode($oddsResponse, true);

            if (isset($oddsData['error']) && $oddsData['error'] == 'EVENT_NOT_FOUND') {
                return response()->json([
                    'error' => 'Event not found. The event may have expired or the event id is invalid.',
                    'details' => $oddsData['message'],
                    'error_code' => $oddsData['error_code'],
                    'details_url' => $oddsData['details_url']
                ], 404);
            }

            if (empty($oddsData)) {
                return response()->json(['error' => 'No odds data found for the requested Event ID.'], 404);
            }

            return response()->json([
                'error' => false,
                'data' => $oddsData
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //----------------------------------------------------- participants -----------------------------------------------//

    public function participants()
    {
        try {
            $curl = curl_init();

            $apiKey = "6d37b47f19cd9291c267b58924f029de";
            $sport = "basketball_nba";
            $apiUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/participants?apiKey={$apiKey}";

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

            return response()->json([
                'error' => false,
                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['error' => 'An error occurred: ' . $sortmessage], 500);
        }
    }

    //-------------------------------------------------------historical_odds ------------------------------------------------//

    public function isFreePlan()
    {
        // Assuming the User model has a 'plan' attribute and 'free' represents the free plan.
        $user = auth()->user(); // Get the currently authenticated user

        // If no user is logged in or the user is on a free plan
        return $user && $user->plan === 'free';
    }

   
    public function historical_odds(Request $request)
    {
        try {
            $apiKey = env('THE_ODDS_API_KEY');
    
            if (empty($apiKey)) {
                return response()->json([
                    'error' => 'API key is missing. Please check your environment configuration.'
                ], 400);
            }
    
            Log::info('Using API Key: ' . $apiKey);
    
            $sport = $request->input('sport');
            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }
    
            // Check if the user is on the free plan
            if ($this->isFreePlan()) {
                return response()->json([
                    'error' => 'Historical odds are not available on the free plan. Please upgrade your plan for this feature.',
                    'details_url' => 'https://the-odds-api.com/liveapi/guides/v4/api-error-codes.html#historical-unavailable-on-free-usage-plan'
                ], 403);
            }
    
            // Get other parameters from the request
            $regions = $request->input('regions', 'us');
            $markets = $request->input('markets', 'h2h');
            $oddsFormat = $request->input('oddsFormat', 'american');
            $date = $request->input('date');
    
            if (empty($date)) {
                return response()->json([
                    'error' => 'Date is required in ISO 8601 format (e.g., 2021-10-18T12:00:00Z).'
                ], 400);
            }
    
            // Validate date format
            $dateFormat = 'Y-m-d\TH:i:s\Z';
            $dateObj = \DateTime::createFromFormat($dateFormat, $date);
            if (!$dateObj || $dateObj->format($dateFormat) !== $date) {
                return response()->json([
                    'error' => 'Invalid date format. Please use ISO 8601 format (e.g., 2021-10-18T12:00:00Z).'
                ], 400);
            }
    
            // API URL
            $apiUrl = "https://api.the-odds-api.com/v4/historical/sports/{$sport}/odds/?apiKey={$apiKey}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}&date={$date}";
    
            Log::info("Request URL: {$apiUrl}");
    
            // cURL setup and execution
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
    
            Log::info("HTTP Status Code: {$statusCode}");
            Log::info("Full API Response: {$response}");
    
            if ($statusCode !== 200) {
                // Check if the error is related to free plan restrictions
                if (strpos($response, 'HISTORICAL_UNAVAILABLE_ON_FREE_USAGE_PLAN') !== false) {
                    return response()->json([
                        'error' => 'Historical odds are only available on paid usage plans.',
                        'details_url' => 'https://the-odds-api.com/liveapi/guides/v4/api-error-codes.html#historical-unavailable-on-free-usage-plan'
                    ], 403);
                }
    
                Log::error("Error from The Odds API, status code: {$statusCode}, response: {$response}");
                return response()->json(['error' => "Error response from The Odds API: {$response}"], $statusCode);
            }
    
            // Decode the response
            $responseData = json_decode($response, true);
            Log::info("API Response Data: ", ['response' => $responseData]);
    
            if (empty($responseData['data'])) {
                return response()->json(['error' => 'No data returned for the given date.'], 404);
            }
    
            // Prepare the response data
            $oddsData = [
                'timestamp' => $responseData['timestamp'] ?? null,
                'previous_timestamp' => $responseData['previous_timestamp'] ?? null,
                'next_timestamp' => $responseData['next_timestamp'] ?? null,
                'data' => []
            ];
    
            foreach ($responseData['data'] as $event) {
                $oddsData['data'][] = [
                    'id' => $event['id'],
                    'sport_key' => $event['sport_key'],
                    'sport_title' => $event['sport_title'],
                    'commence_time' => $event['commence_time'],
                    'home_team' => $event['home_team'],
                    'away_team' => $event['away_team'],
                    'bookmakers' => array_map(function ($bookmaker) {
                        return [
                            'key' => $bookmaker['key'],
                            'title' => $bookmaker['title'],
                            'last_update' => $bookmaker['last_update'],
                            'markets' => array_map(function ($market) {
                                return [
                                    'key' => $market['key'],
                                    'outcomes' => array_map(function ($outcome) {
                                        return [
                                            'name' => $outcome['name'],
                                            'price' => $outcome['price']
                                        ];
                                    }, $market['outcomes'])
                                ];
                            }, $bookmaker['markets'])
                        ];
                    }, $event['bookmakers'])
                ];
            }
    
            return response()->json($oddsData);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }
    
}
