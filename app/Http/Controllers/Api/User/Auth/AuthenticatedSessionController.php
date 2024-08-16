<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Mail\SendMail;
use Mail;
use App\Models\User;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Traits\OtpTrait;
use Illuminate\View\View;

class AuthenticatedSessionController extends BaseController
{
    use OtpTrait;
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**if (! $token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        // if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
          
            
        // }
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $credentials = request(['email', 'password']);
            if (!Auth::guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email or password is incorrect',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $otp = $this->generateUniqueOtp();
            if ($user->verify_otp_status !== 1) {
                $user->otp = $otp;
                $user->otp_expires_at = now()->addMinutes(10);
                $user->save();
                
                Mail::to($user->email)->send(new SendMail($user, 'Otp verification code'));
                return response()->json([
                    'data' =>[
                        'email'=>$user->email,
                        'otp'=>$user->otp,
                        'verify_otp_status'=>$user->verify_otp_status,
                    ],
                    'success' => false,
                    'message' => 'Your account is not verified. please verified first.',
                ], 403);
            }
            // Check if the user is active
            if ($user->status !== 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is not active. Please contact support.',
                ], 403);
            }


            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => true,
                'message' => 'User logged in successfully!',
                'token' => $token,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => 'false',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }


    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
     
        try {
            $user = Auth::guard('api')->user();
            if ($user) {
                $user->verify_otp_status = 0;
                $user->save();
            }
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out!'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'message' => 'User login successfully!.',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 600
        ]);
    }
    public function profile()
    {
        try {
            $user = Auth::guard('api')->user();
            if (!empty($user)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Profile get successfully',
                        'data' => $user,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'No Record found',
                        'data' => $user,
                    ],
                    200
                );
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
