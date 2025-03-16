<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function my_picks(){

        if(session()->has('user_id')){
            return view('user.my_picks');
        }else{
            return redirect('/');
        }
        
    }


    public function account_overview(){
        if(session()->has('user_id')){
            return view('user.account_overview');
        }else{
            return redirect('/');
        }
        
    }
}
