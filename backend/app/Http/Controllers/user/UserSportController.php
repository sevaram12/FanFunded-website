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

            $sportData = $responseData;

           return view('user.sport.sport_details',compact('sportData'));

        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message, '(');

            return response()->json(['error' => 'An error occurred: ' . $sortmessage], 500);
        }
    }




    public function odds(Request $request)
    {
        try {
            $sport = $request->input('sport');

            if (empty($sport)) {
                return response()->json([
                    'error' => 'Sport key is required.'
                ], 400);
            }

            // dd($sport);

            $apiKey = "6d37b47f19cd9291c267b58924f029de";
            $regions = $request->input('regions','us');
            $markets = $request->input('markets','h2h,totals,spreads');
            $oddsFormat = $request->input('oddsFormat','american');

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
                return view('user.sport.american-football')->with('error','Error Not connecting with odds data');
                // return response()->json(['status' => 'Error connecting to The Odds API.'], 500);
            }

            $responseData = json_decode($response, true);
            $oddsData = $responseData;

            Log::info('API response data:', ['response_data' => $responseData]);

            // dd($oddsData);
            return view('user.sport.american-football',compact('oddsData'));

        } catch (Exception $exception) {
            $message = $exception->getMessage();
            $sortmessage = strtok($message,'(');

            return redirect('user.sport.american-football')->with('error','An error occured: '.$sortmessage);
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
                return redirect('score')->with('fail','The API returned an invalid response.');
            }

            // Log::info('API response data:', ['response_data' => $responseData]);

            $scoreData = $responseData;

            if (empty($responseData)) {

                return redirect('score')->with('fail','No scores found for the requested NBA games.');
                
            }


            return view('user.partial.header',compact('scoreData'));

            
        } catch (Exception $exception) {
            Log::error("Exception: {$exception->getMessage()}");
            return response()->json(['error' => 'An error occurred: ' . $exception->getMessage()], 500);
        }
    }







}
