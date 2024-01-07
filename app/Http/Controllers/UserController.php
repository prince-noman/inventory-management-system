<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UserController extends Controller
{

    function LoginPage():View{
        return view('pages.auth.login-page');
    }

    function RegistrationPage():View{
        return view('pages.auth.registration-page');
    }
    function SendOtpPage():View{
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage():View{
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage():View{
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage():View{
        return view('pages.dashboard.profile-page');
    }



    //User Registration
    public function userRegistration(Request $request){

        try{
            User::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'password' => $request->password,
                'mobile' => $request->mobile,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successful'
            ], 200);
            
        }catch(\Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'User Registration Failed'
            ], 200);
        }
        
    }

    //User Login
    public function userLogin(Request $request){
        //         $validator = Validator::make($request->all(), [
        //             'first_name' => 'required|max:255',
        //             'last_name' => 'required|max:255',
        //             'email' => 'required',
        //             'is_active' => 'required'
        //    ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors'=>$validator->errors()],422);
        // }
        $count = User::where(['email' => $request->email, 'password' => $request->password])->select('id')->first();

        if($count !== null){
            // User Login and Issue JWT Token
            $token = JWTToken::createToken($request->input('email'), $count->id);
            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successful'
            ], 200)->cookie('token', $token, time()+60 * 24 * 30);
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'User Login Failed'
            ], 200);
        }
    }

    //Send OTP
    public function sendOTP(Request $request){
        $email = $request->email;
        $otp = rand(1000, 9999);
        $count = User::where('email', $email)->count();

        if($count == 1){
            //Send OTP to Email Address
            Mail::to($email)->send(new OTPMail($otp));
            //Save OTP in DB
            User::where('email', $email)->update(['otp' => $otp]);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unable to send OTP'
            ], 200);
        }

       
    }

    //Verify OTP
    public function verifyOTP(Request $request){
        $email = $request->email;
        $otp = $request->otp;
        $count = User::where(['email' => $email, 'otp' => $otp])->count();

        if($count == 1){
            // Update OTP in DB
            User::where('email', $email)->update(['otp' => 0]);
            //Password Reset Token
            $token = JWTToken::createTokenForSetPassword($email);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified successfully',
            ], 200)->cookie('token', $token, 500);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'OTP verification failed'
            ], 200);
        }
    }

    //Reset Password
    public function resetPassword(Request $request){
        try{
            $email = $request->header('email');
            $password = $request->password;
            //Update Password
            User::where('email', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset successful'
            ], 200);

        }catch(\Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Password Reset Failed'
            ], 200);
        }
    }

    // User Logout
    public function userlogout(Request $request)
    {
        return redirect('/userLogin')->cookie('token', null, -1);
    }

    //get user profile
    function UserProfile(Request $request){
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ],200);
    }

    //update user profile
    function UpdateProfile(Request $request){
        try{
            $email=$request->header('email');
            $firstName=$request->input('first_name');
            $lastName=$request->input('last_name');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            User::where('email','=',$email)->update([
                'first_name'=>$firstName,
                'last_name'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);

        }catch (\Exception $exception){
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }
}