<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function signup(Request $request){
        $validate = Validator::make($request->all(),[
            ''
        ]);

        
    }
}
