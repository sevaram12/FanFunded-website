<?php

namespace App\Http\Controllers\admin\api;

use App\Http\Controllers\Controller;
use App\Models\BillingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillingController extends Controller
{
    public function billing_details(Request $request){

        $validate = Validator::make($request->all(),[
            'user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'house_no_and_street_name' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'phone_no' => 'required',
            'email' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'result' => false,
                'status' => 422,
                'message' => 'All fields are required',
                'error' => $validate->errors()
            ],422);
        }

        $billing = new BillingDetail();

        $billing->user_id = $request->user_id;
        $billing->first_name = $request->first_name;
        $billing->last_name = $request->last_name;
        $billing->country = $request->country;
        $billing->house_no_and_street_name = $request->house_no_and_street_name;
        $billing->city = $request->city;
        $billing->postcode = $request->postcode;
        $billing->phone_no = $request->phone_no;
        $billing->email = $request->email;

        $billing->save();

        return response()->json([
            'result' => true,
            'status' => 200,
            'message' => 'Billing details submited successfully!!',
            'billing_detail' => $billing
        ],200);
    }
}
