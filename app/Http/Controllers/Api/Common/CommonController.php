<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeUser;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Api\BaseController as BaseController;


class CommonController extends BaseController
{
    public function verifyOtp(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|integer',
            'type' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            $user = null;
            if ($request->type === 'user') {
                
                $user = User::where('email', $request->email)->first();
             
            } elseif ($request->type === 'employee_user') {
               $user = EmployeeUser::where('email', $request->email)->first();
            }else{
                return $this->sendError('Type is not specified correctly.', [], 400);
            }
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found.'], 404);
            }
            if ($user->otp === (int) $request->otp && Carbon::parse($user->otp_expires_at)->isFuture()) {
                $user->verify_otp_status = true;
                $user->status = 1;
                $user->save();
                return response()->json(['success' => true, 'message' => 'OTP verified successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'There was an error verifying the OTP. Please try again.'], 500);
        }

    }
}
