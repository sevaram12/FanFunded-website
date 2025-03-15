<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function my_picks(){
        return view('user.my_picks');
    }


    public function account_overview(){
        return view('user.account_overview');
    }
}
