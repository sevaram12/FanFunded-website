<?php

namespace App\Http\Controllers\admin;

use App\Models\Betting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function test()
    {
        return view('admin.test');
    }

    public function test1()
    {
        return view('user.test1');
    }

    public function pick_history()
    {
        // Fetch betting records with user details
        $pickslips = Betting::with('user')->orderBy('created_at', 'desc')->get();
    
        // Separate winning and losing bets
        $winningDetails = [];
        $losingDetails = [];
    
        foreach ($pickslips as $pickslip) {
            $betData = [
                'user' => $pickslip->user ? $pickslip->user->name : 'Unknown',
                'created_at' => $pickslip->created_at->format('Y-m-d H:i:s'),
                'game' => $pickslip->game ?? '',
                'bet_type' => $pickslip->bet_type ?? '',
                'team' => $pickslip->team ?? '',
                'spread' => $pickslip->spread ?? '',
                'odds' => $pickslip->odds ?? '',
                'total_pick' => $pickslip->total_pick ?? 0,
                'payout' => $pickslip->payout ?? 0,
                'pick_id' => $pickslip->pick_id ?? '',
                'straight_bets' => json_decode($pickslip->straight_bets, true) ?? [],
                'parlay_bets' => json_decode($pickslip->parlay_bets, true) ?? [],
                'total_collect' => json_decode($pickslip->total_collect, true) ?? ['straight' => 0, 'parlay' => 0],
                'status' => $pickslip->status ?? 'pending'
            ];
    
            if ($pickslip->status === 'win') {
                $winningDetails[] = $betData;
            } else {
                $losingDetails[] = $betData;
            }
        }
    
        return view('admin.auth.pick_history', compact('winningDetails', 'losingDetails','pickslips'));
    }
    
}
