<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Carbon\Carbon;
use App\Traits\OtpTrait;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Api\BaseController as BaseController;


class CommonController extends BaseController
{
    use OtpTrait;
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|integer',
           
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            $user = null;

            if ($request->email) {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $user = EmployeeUser::where('email', $request->email)->first();
                }
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
    public function resendOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            $user = null;

            if ($request->email) {
                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    $user = EmployeeUser::where('email', $request->email)->first();
                }
                if ($user) {
                    $otp = $this->generateUniqueOtp();
                    $user->otp = $otp;
                    $user->otp_expires_at = now()->addMinutes(10);
                    $user->save();
                    Mail::to($user->email)->send(new SendMail($user, 'Otp verification code'));

                    return $this->sendResponse('Resend OTP successfully.', []);
                } else {
                    return $this->sendError('User not found.', [], 400);
                }
            }

        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            return $this->sendError('There was an error to resend the OTP. Please try again.', [], 500);
        }
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'user_type' => ['required', 'in:user,employee_user'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            if ($request->user_type === 'user') {
                $user = User::where('email', $request->email)->first();
            } else {
                $user = EmployeeUser::where('email', $request->email)->first();
            }
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Email not found.'], 404);
            }


            $otp = $this->generateUniqueOtp();
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->verify_otp_status = false;
            $user->save();

            Mail::to($user->email)->send(new SendMail($user, 'Reset password code'));

            return $this->sendResponse('OTP is sent on your email', []);

        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()], 500);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'user_type' => ['required', 'in:user,employee_user'],
            'new_password' => ['required', 'string', 'min:4'], // Ensure password validation
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            if ($request->user_type === 'user') {
                $user = User::where('email', $request->email)->first();
            } else {
                $user = EmployeeUser::where('email', $request->email)->first();
            }

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Email not found.'], 404);
            }

            if ($user->verify_otp_status !== 1) {
                return $this->sendError('Your OTP is not verified. please verified first.', $validator->errors(), 403);
            }

            if ($user->verify_otp_status == true && Carbon::parse($user->otp_expires_at)->isFuture()) {

                $user->password = Hash::make($request->new_password);
                $user->save();

                return $this->sendResponse('Password reset successfully.', []);
            } else {

                return $this->sendError('Time is expired, try again', [], 400);

            }
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()], 500);
        }

    }
    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_type' => ['required', 'in:user,employee_user'],
            'old_password' => ['required', 'string', 'min:4'],
            'new_password' => ['required', 'string', 'min:4', 'confirmed'],
            'new_password_confirmation' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        try {
            if ($request->user_type === 'user') {

                $user = User::where('id', Auth('api')->user()->id)->first();
            } else {
                $user = Auth('employeeUser')->user();
                $user = EmployeeUser::where('id', Auth('employeeUser')->user()->id)->first();
            }
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }
            if (!Hash::check($request->old_password, $user->password)) {
                return $this->sendError('Old password does not match', [], 400);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->sendResponse('Password changed successfully.', []);
        } catch (\Exception $e) {
            return $this->sendError('An error occurred', ['error' => $e->getMessage()], 500);
        }
    }
}
