<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;


use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
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
        // dd($request);
        $validator = Validator::make($request->all(), [

            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $credentials = request(['email', 'password']);
        if (!Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email or password is incorrect',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // Check if the user is active
        if ($user->status !== 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Your account is not active. Please contact support.',
            ], 403);
        }

        $token = Auth::guard('api')->attempt($credentials);

        return $this->respondWithToken($token);





        // $request->authenticate();

        // $request->session()->regenerate();


        // return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // dd('fdddd');
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out!'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
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
        $user = Auth::guard('api')->user();
        if (!empty($user)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'success',
                    'data' => $user,
                ],
                200
            );

        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'No Record found',
                    'data' => $user,
                ],
                200
            );
        }


    }
}
