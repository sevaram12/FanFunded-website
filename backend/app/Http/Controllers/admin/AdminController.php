<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function test(){
        return view('admin.test');
    }

    public function test1(){
        return view('user.test1');
    }
}
