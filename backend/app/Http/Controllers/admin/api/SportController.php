<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SportController extends Controller
{

    //----------------------------------------------------- sports -----------------------------------------------//

    public function sports()
    {
        try {

            $curl = curl_init();


            $apiUrl = "https://api.the-odds-api.com/v4/sports/?apiKey=2ebaa2bd23eaa0170c2aaff6eebcc1ee";


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
                return response()->json(['status' => 'status connecting to The Odds API.'], 500);
            }

            $responseData = json_decode($response, true);

            if (empty($responseData)) {
                return response()->json(['status' => 'No data returned from The Odds API.'], 500);
            }

            return response()->json([

                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['status' => 'An error occurred: ' . $sortmessage], 500);
        }
    }

    //-------------------------------------------------------scores ------------------------------------------------//

    public function scores(Request $request)
    {
        try {

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

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

                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //--------------------------------------------------------getEventOdds ------------------------------------------//

    public function getEventOdds(Request $request)
    {
        try {

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

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

                'data' => $oddsData
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $exception->getMessage()], 500);
        }
    }

    //----------------------------------------------------- participants ---------------------------------------------//

    public function participants()
    {
        try {
            $curl = curl_init();

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

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

                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['error' => 'An error occurred: ' . $sortmessage], 500);
        }
    }

    //--------------------------------------------------------odds --------------------------------------------------//

    public function odds(Request $request)
    {
        try {
            $sport = $request->input('sport');
    
            if (empty($sport)) {
                return response()->json(['error' => 'Sport key is required.'], 400);
            }

    

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

            $regions = $request->input('regions', 'us');  // Default to 'us'
            $markets = $request->input('markets', 'h2h,totals,spreads');  // Default markets
            $oddsFormat = $request->input('oddsFormat', 'american');  // Default odds format
    

            $apiUrl = "https://api.the-odds-api.com/v4/sports/{$sport}/odds/?apiKey={$apiKey}&regions={$regions}&markets={$markets}&oddsFormat={$oddsFormat}";
    
            // Initialize cURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            ]);
    
            // Execute request
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
    
            // Handle connection error
            if ($err) {
                return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
            }
    
            // Decode JSON response
            $responseData = json_decode($response, true);
    
            // Handle API errors or empty responses
            if ($statusCode !== 200 || empty($responseData)) {
                return response()->json([
                    'error' => 'No data available or invalid API response.',
                    'status_code' => $statusCode
                ], 400);
            }
    
            // Format response
            $oddsData = [];
            foreach ($responseData as $event) {
                $bookmakersData = [];
    
                foreach ($event['bookmakers'] as $bookmaker) {
                    $marketsData = [];
    
                    foreach ($bookmaker['markets'] as $market) {
                        $outcomesData = [];
    
                        foreach ($market['outcomes'] as $outcome) {
                            $outcomesData[] = [
                                'name' => $outcome['name'],
                                'price' => $outcome['price'],
                                'point' => $outcome['point'] ?? null
                            ];
                        }
    
                        $marketsData[] = [
                            'key' => $market['key'],
                            'outcomes' => $outcomesData
                        ];
                    }
    
                    $bookmakersData[] = [
                        'key' => $bookmaker['key'],
                        'title' => $bookmaker['title'],
                        'last_update' => $bookmaker['last_update'],
                        'markets' => $marketsData
                    ];
                }
    
                $oddsData[] = [
                    'id' => $event['id'],
                    'sport_key' => $event['sport_key'],
                    'sport_title' => $event['sport_title'],
                    'commence_time' => $event['commence_time'],
                    'home_team' => $event['home_team'],
                    'away_team' => $event['away_team'],
                    'bookmakers' => $bookmakersData,
                ];
            }
    
            return response()->json(['data' => $oddsData]);
    
        } catch (Exception $exception) {
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }
    

    public function historical_odds(Request $request)
    {
        try {

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

            $sport = $request->input('sport', 'basketball_nba');
            $date = $request->input('date');

            if (empty($date)) {
                return response()->json([
                    'error' => 'Date is required for historical odds.'
                ], 400);
            }

            $timezone = 'UTC';
            $currentDate = Carbon::now($timezone);
            $providedDate = Carbon::parse($date, $timezone);

            Log::info('Current Date:', ['current_date' => $currentDate->toIso8601String()]);
            Log::info('Provided Date:', ['provided_date' => $providedDate->toIso8601String()]);

            $apiUrl = "https://api.the-odds-api.com/v4/historical/sports/{$sport}/odds/?apiKey={$apiKey}&regions=us&markets=h2h&oddsFormat=american&date={$date}";

            $response = $this->makeApiRequest($apiUrl);

            if (empty($response['data'])) {
                return response()->json(['error' => 'No historical odds data found.'], 404);
            }

            $formattedResponse = [
                'timestamp' => Carbon::now()->toIso8601String(),
                'previous_timestamp' => Carbon::now()->subMinutes(10)->toIso8601String(),
                'next_timestamp' => Carbon::now()->addMinutes(10)->toIso8601String(),
                'data' => $this->formatOddsData($response['data']),
            ];

            return response()->json($formattedResponse);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    private function makeApiRequest($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error("cURL error: {$err}");
            return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
        }

        return json_decode($response, true);
    }

    //--------------------------------------------------------events ------------------------------------------------//

    public function events(Request $request)
    {
        try {


            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";


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

                'data' => $responseData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    public function historicalevents(Request $request)
    {
        try {

            $apiKey = "2ebaa2bd23eaa0170c2aaff6eebcc1ee";

            $date = $request->input('date');
            $sport = $request->input('sport', 'basketball_nba');  // Default to basketball_nba

            // Validate the date input
            if (empty($date)) {
                return response()->json([
                    'error' => 'Date is required for historical events.'
                ], 400);
            }

            // Format the date to 'YYYY-MM-DD' (If it's in ISO 8601 format, like '2025-03-05T08:36:00Z')
            $formattedDate = Carbon::parse($date)->toDateString();  // 'YYYY-MM-DD'

            // Log the formatted date to ensure it's correct
            Log::info('Formatted Date:', ['formatted_date' => $formattedDate]);

            // Construct the API URL with the formatted date
            $apiUrl = "https://api.the-odds-api.com/v4/historical/sports/{$sport}/events?apiKey={$apiKey}&date={$formattedDate}";

            // Log the API URL for debugging
            Log::info('API URL:', ['url' => $apiUrl]);

            // Make the cURL request
            $response = $this->makeApiRequest($apiUrl);

            // Log the raw response to see what is returned
            Log::info('API Response Data:', ['response' => $response]);

            // Check if response contains data
            if (isset($response['data']) && !empty($response['data'])) {
                // Format the response as needed
                $formattedResponse = [
                    'timestamp' => Carbon::now()->toIso8601String(),
                    'data' => $this->formatEventsData($response['data']),
                ];
                return response()->json($formattedResponse);
            }

            return response()->json([
                'error' => 'No historical event data found for the given date.'
            ], 404);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }

    private function formatEventsData($data)
    {
        $formattedData = [];
        foreach ($data as $event) {
            $formattedData[] = [
                'id' => $event['id'],
                'sport_key' => $event['sport_key'],
                'sport_title' => $event['sport_title'],
                'commence_time' => $event['commence_time'],
                'home_team' => $event['home_team'],
                'away_team' => $event['away_team'],
                'bookmakers' => $event['bookmakers'],
            ];
        }
        return $formattedData;
    }

    public function historical_event_odds(Request $request)
    {
        try {
            // Capture inputs from the request
            $eventId = $request->input('eventId');
            $date = $request->input('date');
            $regions = $request->input('regions', 'us');
            $markets = $request->input('markets', 'player_points,h2h_q1');



            $apiKey = env('2ebaa2bd23eaa0170c2aaff6eebcc1ee');



            if (!$apiKey) {
                return response()->json(['error' => 'API key is not configured.'], 500);
            }


            $apiUrl = "https://api.the-odds-api.com/v4/historical/sports/basketball_nba/events/{$eventId}/odds?apiKey={$apiKey}&date={$date}&regions={$regions}&markets={$markets}";

            // Log the API URL
            Log::info("API URL: {$apiUrl}");

            // Initialize cURL session
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                [
                    CURLOPT_URL => $apiUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                    ],
                ]
            );

            // Execute the cURL request
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            // Log status code and raw response
            Log::info("API Response Status Code: {$statusCode}");
            Log::info("Raw API Response: {$response}");

            // Handle cURL errors
            if ($err) {
                Log::error("cURL error: {$err}");
                return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
            }

            // Handle API request failures
            if ($statusCode !== 200) {
                Log::error("API request failed with status code {$statusCode}");
                return response()->json(['error' => 'The API request failed.'], 500);
            }

            // Decode JSON response
            $responseData = json_decode($response, true);

            // Handle invalid JSON response
            if ($responseData === null) {
                Log::error('Invalid JSON response from The Odds API.', ['response' => $response]);
                return response()->json(['error' => 'Invalid JSON response from The Odds API.'], 500);
            }

            // Handle empty response data
            if (empty($responseData)) {
                return response()->json([
                    'error' => true,
                    'message' => 'No odds data found for the event.'
                ], 404);
            }

            // Log API response data
            Log::info('API response data:', ['response_data' => $responseData]);

            // Process and format the data for response
            $oddsData = [];
            if (is_array($responseData)) {
                foreach ($responseData as $event) {
                    $bookmakersData = [];
                    foreach ($event['bookmakers'] as $bookmaker) {
                        $marketsData = [];
                        foreach ($bookmaker['markets'] as $market) {
                            $outcomesData = [];
                            foreach ($market['outcomes'] as $outcome) {
                                $outcomesData[] = [
                                    'name' => $outcome['name'],
                                    'price' => $outcome['price'],
                                    'point' => $outcome['point'] ?? null,
                                ];
                            }
                            $marketsData[] = [
                                'key' => $market['key'],
                                'outcomes' => $outcomesData
                            ];
                        }

                        $bookmakersData[] = [
                            'key' => $bookmaker['key'],
                            'title' => $bookmaker['title'],
                            'last_update' => $bookmaker['last_update'],
                            'markets' => $marketsData,
                        ];
                    }

                    $oddsData[] = [
                        'id' => $event['id'],
                        'sport_key' => $event['sport_key'],
                        'sport_title' => $event['sport_title'],
                        'commence_time' => $event['commence_time'],
                        'home_team' => $event['home_team'],
                        'away_team' => $event['away_team'],
                        'bookmakers' => $bookmakersData,
                    ];
                }
            } else {
                // Handle the case where response data is not an array
                Log::error("Expected an array but got a non-array response data.");
                return response()->json(['error' => 'Expected an array but got a non-array response data.'], 500);
            }

            return response()->json([
                'timestamp' => now()->toISOString(),
                'previous_timestamp' => now()->subMinutes(5)->toISOString(),
                'next_timestamp' => now()->addMinutes(5)->toISOString(),
                'data' => $oddsData
            ]);
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }
}
