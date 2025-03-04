<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function signup(Request $request){
        $validate = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|min:10',
            'password' => [
                            'required',
                            'string',
                            'min:6',
                            'regex:/^\S*$/u', // No spaces
                            'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least one special character
                            'regex:/[0-9]/', // At least one number
                        ],
                'confirm_password' => 'required|same:password'
        ],[
            'password.regex' => 'The password must be at least 6 characters, contain no spaces, at least one special character, and one number.',
        ]);

        if($validate->fails()){
            return response()->json([
                'result' => false,
                'message' => 'All fields Required',
                'status' => 422,
                'error' => $validate->errors()
            ],422);
        }


        $data = new User();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone_no = $request->phone_no;
        $data->password = bcrypt($request->password);

        $result = $data->save();

        if($result){
            return response()->json([
                'result' => true,
                'message' => "Registration Successfully!!",
                'status' => 200,
                'data' => $data,
            ],200);
        }else{
            return response()->json([
                'result' => false,
                'error' => "Registration Failed!!",
                'status' => 400,
            ],400);
        }
    }


    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'result' => false,
                'message' => 'All Field Required',
                'status' => 422,
                'error' => $validate->errors()
            ],422);
        }

        $user = User::where('email',$request->email)->first();

        $email = $request->email;
        $password = $request->password;

        if($user){
            if(Hash::check($password,$user->password)){
                if($user->role == 0){
                    return response()->json([
                        'result' => true,
                        'message' => "Login Successfully!!",
                        'status' => 200,
                        'user' => $user->id
                    ],200);
                }else{
                    return response()->json([
                        'result' => false,
                        'error' => "Invalid Credintial!!",
                        'status' => 400,
                    ],400);
                }
            }else{
                return response()->json([
                    'result' => false,
                    'error' => "Incorrect Password!!",
                    'status' => 400,
                ],400);
            }
        }else{
            return response()->json([
                'result' => false,
                'error' => "Incorrect Email!!",
                'status' => 400,
            ],400);
        }
    }


    public function logout(Request $request){
        
        $validate = Validator::make($request->all(),[
                'id' => 'required',
        ]);
        
        $user = User::where('id',$request->id)->first();
        
        if($user){
            session()->forget($user->id);
            return response()->json(data: [
                'status' => true,
                'message' => 'Logout Successfully ' .$user->name,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'error' => 'Logout failed!!',
            ],400);
        }
    }
}
