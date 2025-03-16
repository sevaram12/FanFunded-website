<?php

namespace App\Http\Controllers\user\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    //

    public function logout(){

        // dd(session()->get('user_id'));

        if (session()->has("user_id")) {
            session()->forget('user_id');
            return redirect("/")->with("success", "Logout Successfully!");
        
        } else {
            return redirect("/")->with("error", "No user is logged in.");
        }
    }
}
