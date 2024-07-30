<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerifyOtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\OtpTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\EmployeeUser;
use App\Http\Controllers\Api\BaseController as BaseController;



class PasswordResetLinkController extends BaseController
{
    use OtpTrait;

    public function store(Request $request)
    {
        dd($request);
        $otp = $this->generateUniqueOtp();
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 400);
        }
        if ($request->user_type === 'user') {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->user_type === 'employee_user') {
            $user = EmployeeUser::where('email', $request->email)->first();
        }else{
            return $this->sendError('User type not specified', [], 400);
        }
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Email not found.'], 404);
        }
      $user->otp =$otp;
      $user->otp_expires_at =now()->addMinutes(10);
      $user->verify_otp_status =true;
      $user->save();
      Mail::to($user->email)->send(new SendMail($user, 'Reset password code'));
      
      return $this->sendResponse('OTP is sent on your email', $user);

        
       
       
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // $status == Password::RESET_LINK_SENT
        //     ? back()->with('status', __($status))
        //     : back()->withInput($request->only('email'))
        //         ->withErrors(['email' => __($status)]);


        // return response()->json(['status' => true, 'message' => 'OTP sent to your email.'], 200);
    }

}
