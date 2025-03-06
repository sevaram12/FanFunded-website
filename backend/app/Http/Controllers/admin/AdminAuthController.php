<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function user_details(){

        $userDetail = User::where('role','0')->get();
        return view('admin.auth.user_details',compact('userDetail'));
    }
}
