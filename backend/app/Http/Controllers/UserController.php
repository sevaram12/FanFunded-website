<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function my_picks(){
        return view('user.my_picks');
    }
}
