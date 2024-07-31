<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OtpController extends Controller
{
    public function verifyOtp(){

    }
    public function generateUniqueOtp(){
        do {
            $otp = rand(1000, 9999);
            $otpExists = DB::table('users')->where('otp', $otp)->exists() || DB::table('employee_users')->where('otp', $otp)->exists();
        } while ($otpExists);
    
        return $otp;
    }
}
