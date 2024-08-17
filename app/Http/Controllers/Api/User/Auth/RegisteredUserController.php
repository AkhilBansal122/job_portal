<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Traits\OtpTrait;
use Illuminate\View\View;

class RegisteredUserController extends BaseController
{
    use OtpTrait;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class,'unique:employee_users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone_number' => 'required|string|regex:/^[0-9]{10,10}$/',
            'address' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            $emailValidationFailed = $validator->errors()->has('email') && $request->email;

            return response()->json([
                'status' => false,
                'message' => $emailValidationFailed ? 'Already taken' : 'Validation error',
                'emailValidation' => !$emailValidationFailed,
            ], 400);
        }
        try {
            $otp = $this->generateUniqueOtp();

            if ($image = $request['profile_image']) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('images/user', $imageName);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'status' => 1,
                'profile_image' => $imageName ?? '',
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
            ]);

            if ($user) {
                Mail::to($user->email)->send(new SendMail($user, 'Otp verification code'));
                return $this->sendResponse('User created successfully', $user);
            }
        } catch (\Exception $e) {
            return $this->sendError('There is some problem', ['error' => $e->getMessage()], 500);
        }
    }

}
