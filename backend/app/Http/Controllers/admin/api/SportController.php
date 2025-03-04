<?php

namespace App\Http\Controllers\admin\api;

use Illuminate\Support\Facades\Log;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SportController extends Controller
{
    //----------------------------------------------------------- sports --------------------------------------------------//
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

    //----------------------------------------------------- odds -------------------------------------------------------//

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

    public function events(Request $request)
{
    try {
        // Define the API Key and the 'daysFrom' parameter
        $apiKey = "6d37b47f19cd9291c267b58924f029de";
        $daysFrom = $request->input('daysFrom', 1); // Default is 1 day from today

        // Corrected URL for NFL events
        $apiUrl = "https://api.the-odds-api.com/v4/sports/americanfootball_nfl/events?daysFrom={$daysFrom}&apiKey={$apiKey}";

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
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

        // Execute cURL and capture the response
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Handle cURL error
        if ($err) {
            Log::error("cURL error: {$err}");
            return response()->json(['error' => 'Error connecting to The Odds API.'], 500);
        }

        // Log the response and status code for debugging
        Log::info('The Odds API Response:', ['response' => $response, 'status_code' => $statusCode]);

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Check if the response is valid
        if ($responseData === null) {
            Log::error('Invalid JSON response from the API:', ['response' => $response]);
            return response()->json(['error' => 'The API returned an invalid response.'], 500);
        }

        // Log the API response data
        Log::info('API response data:', ['response_data' => $responseData]);

        // Handle empty response (no events)
        if (empty($responseData)) {
            return response()->json([
                'error' => "No events found for the requested NFL games."
            ], 404);
        }

        // Return the response data as JSON
        return response()->json([
            'error' => false,
            'data' => $responseData
        ]);
    } catch (Exception $exception) {
        // Catch any exceptions and log them
        Log::error("Exception: {$exception->getMessage()}");
        return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
    }
}

}