<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Models\User;
use App\Models\Verify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
#use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                //'phone_number' => 'digits:11',
                'phone_number' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'first_name' => $request->last_name,
                'last_name' => $request->first_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password)
            ]);

	    //event(new Registered($user));

	$pin=random_int(1000,9999);
 	Verify::create([
              'email' => $user->email, 
              'token' =>  Hash::make($pin),
            ]);

	$verify_link=route('verify');
	$mail_message=<<EOD
		Thanks for regestering.
		please click the link below
		to complete registeration process
		<a href="$verify_link?token=$pin">$verify_link?token=$pin<\a>
		END
EOD

        Mail::raw($mail_message, function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
          });
         


	    return response()->json([
                'status' => true,
                'message' => 'User Created Successfully please Check mail for verification link',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
	$loginField = $request->email?'email':'phone_number';
	$loginValidation = $request->email?'required|email':'required|digits:11';    
        try {
            $validateUser = Validator::make($request->all(), 
            [
                #'email' => 'required|email',
                $loginField => $loginValidation,
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only([$loginField, 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email or Phone Number & Password does not match with our record.',
                ], 401);
            }

            $user = User::where($loginField, $request->$loginField)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }



	public function verifyUser(Request $request){
		$email=$request->email;
		$token=$request->token;
		$hash= Hash::make($token);
		$email?: return "no Email";
		$token?: return "no Token";
		$result=$Verify::where('email',$email)->where('token',$hash)->latest()->first();
		if($result){
			User::where('email',$email)->update('email_verified_at',now()
				return "verification success";
		}else
			return "Error";
			

	
	}

	
	function resend(Request $request){
	 $mail_message=<<EOD
                Thanks for regestering.
                please click the link below
                to complete registeration process
                <a href="$verify_link?token=$pin">$verify_link?token=$pin<\a>
                END
EOD

        $result=Mail::raw($mail_message, function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
          });
	$result? return "sent":return "error"
	
	}

    }



}
