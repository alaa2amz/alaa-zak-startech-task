<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function update(Request $request){
	
	  $validateUser = Validator::make($request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,'.$request->user()->id,
                'phone_number' => 'digits:11',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
	    return $request->user()->update(
		    ['first_name' => $request->first_name,
		     'last_name' => $request->last_name,
		     'email' => $request->email,
		     'phone_number' => $request->phone_number,]
	    )?['status'=>true]:['status'=>false];

	}

	function updatePassword(Request $request){
	

	 $validateUser = Validator::make($request->all(),
            [
                'new_password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

               # 'password' => Hash::make($request->password)

	 return $request->user()->update(
		 [ 'password' => Hash::make($request->new_password)]
            )?['status'=>true]:['status'=>false];



	}
}
