<?php
namespace App\Traits;
use Illuminate\Support\Facades\DB;


trait OtpTrait
{
    public function generateUniqueOtp()
    {
        do {
            $otp = rand(1000, 9999);
            $otpExists = DB::table('users')->where('otp', $otp)->exists() || DB::table('employee_users')->where('otp', $otp)->exists();
        } while ($otpExists);
    
        return $otp;
    }

    public function validateOtp($otp)
    {
        // Your OTP validation logic
    }
}