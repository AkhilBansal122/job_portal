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

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\User;
use App\Models\EmployeeUser;


class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {

        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Invalid email format.'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Email not found.'], 404);
        }

        // Generate a unique OTP
        do {
            $otp = rand(100000, 999999);
            $otpExists = DB::table('verify_otps')->where('otp', $otp)->exists();
        } while ($otpExists);

        $criteria = ['email' => $user->email, 'type' => 'user'];
        $attributes = [
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)
        ];

        // // Use the updateOrCreate method
        $verifyOtp = VerifyOtp::updateOrCreate($criteria, $attributes);
        // Assign the unique OTP and expiry time to the admin
        // $verifyOtp = new VerifyOtp;
        // $verifyOtp->email = $admin->email; // Store the email associated with the OTP
        // $verifyOtp->otp = $otp;
        // $verifyOtp->type = 'user';
        // $verifyOtp->otp_expires_at = Carbon::now()->addMinutes(10);
        // $verifyOtp->save();

        //Send OTP via email
        try {
            Mail::raw("Your OTP is $otp", function ($message) use ($user) {
                $message->to($user->email)->subject('Password Reset OTP');
            });
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to send OTP. Please try again later.'], 500);
        }

        return response()->json(['status' => true, 'message' => 'OTP sent to your email.', 'email'=>$user->email], 200);



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
