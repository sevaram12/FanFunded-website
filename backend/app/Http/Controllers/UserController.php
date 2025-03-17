<?php

namespace App\Http\Controllers;

use App\Models\Betting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function my_picks(){

        if(session()->has('user_id')){

            $bettings = Betting::orderBy('id','desc')->get();

            return view('user.my_picks',compact('bettings'));
        }else{
            return redirect('/');
        }
        
    }


    public function account_overview(){
        if(session()->has('user_id')){

            $bettings = Betting::orderBy('id','desc')->get();
            
            return view('user.account_overview',compact('bettings'));
        }else{
            return redirect('/');
        }
        
    }
}
