<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    public function sign_up(){
        return view('admin.auth.signup');
    }


    public function register(Request $request)
    {
        $validate = $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/^\S*$/u', // No spaces
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // At least one special character
                'regex:/[0-9]/', // At least one number
            ],
            "phone_no" => "required|min:10",
        ], [

            'password.regex' => 'The password must be at least 6 characters, contain no spaces, at least one special character, and one number.',
           
        ]);


        if (!$validate) {
            return redirect('signup')->withErrors($validate)->withInput();
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->phone_no = $request->phone_no;
            
            $result = $user->save();

            if ($result) {
                return redirect('/')->with('success', 'Your Registration is Successful!!');
            } else {
                return redirect()->back()->with('error', 'Registration Failed!!');
            }
        }
    }

    public function edit_user_registration()
    {
        $id = session()->get('vendor_id');
        $data = User::find($id);
        return view('user.auth.edit_user_registration', compact('data'));
    }

    public function login(){
        return view('admin.auth.login');
    }


    public function admin_login(Request $request){
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);

        $admin = User::where('email',$request->email)->first();

        if($admin){

            if(Hash::check($request->password,$admin->password)){
                if($admin->role == '1'){
                    return redirect('test')->with('success','Login Successfully');
                }elseif($admin->role ==  '0'){
                    $request->session()->put('user_id',$admin->id);
                    return redirect('test1')->with('success','Login Successfully');
                }else{
                    return redirect()->back()->with('fail','Invalid Credintail!');
                }
            }else{
                return redirect()->back()->with('fail','Invalid Password!');
            }
        }else{
            return redirect()->back()->with('fail','Invalid Email!');
        }
    }
    public function user_details(){

        $userDetail = User::where('role','0')->get();
        return view('admin.auth.user_details',compact('userDetail'));
    }
}
