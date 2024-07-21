<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
use App\Models\VerifyOtp;
use Carbon\Carbon;
use App\Models\User;


class VerifyOtpController extends Controller
{
    //     public function sendOtp(Request $request)
//  {
//  $email = $request->input(‘email’);
//  $otp = rand(100000, 999999); // Generate a 6-digit OTP
//  // Store OTP in Redis with a 5-minute expiration
//  Redis::setex(“otp:$email”, 300, $otp);
//  // Send OTP by email
//  Mail::to($email)->send(new OtpMail($otp));
//  return response()->json([‘message’ => ‘OTP sent successfully’]);
//  }
    // public function verifyOtp(Request $request)
    // {
    //     // dd('fffff');

    //     if ($request->otp) {
    //         $otp= \App\Models\User::where(['id'=> $request->user_id,"otp"=>$request->otp])->first();
    //         if($otp){
    //         $otp->verify_otp_status = 1;
    //             $otp->save();

    //             return response()->json(
    //                 [
    //                     'status' => true,
    //                     'message' => 'Otp verify successfully',
    //                 ],
    //                 200
    //             );
    //         }else{
    //             return response()->json(
    //                 [
    //                     'status' => false,
    //                     'message' => 'There is some problem',
    //                 ],
    //                 200
    //             );
    //         }

    //     }

    // }
    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp' => 'required|numeric']);
        $user = VerifyOtp::where('email', $request->email)->where('otp', $request->otp)->first();
        if (!$user || Carbon::now()->isAfter($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }
        return response()->json(['status' => true, 'message' => 'OTP verified.'], 200);
        
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|string|confirmed'
        ]);

        $user = VerifyOtp::where('email', $request->email)->where('otp', $request->otp)->first();
        dd($user);
        if (!$user || Carbon::now()->isAfter($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }

}
