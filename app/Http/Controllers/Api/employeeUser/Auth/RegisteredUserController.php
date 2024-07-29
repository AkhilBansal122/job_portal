<?php

namespace App\Http\Controllers\Api\employeeUser\Auth;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\EmployeeUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EmployeeUserRegisterRequest;
use Illuminate\View\View;
use Exception;
use App\Models\EmployeeJobRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\SendMail;
use App\Traits\OtpTrait;

use App\Models\Job;

class RegisteredUserController extends Controller
{
    use OtpTrait;
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(EmployeeUserRegisterRequest $request)
    {

        // DB::beginTransaction();

        try {
            $otp = $this->generateUniqueOtp();

            $validatedData = $request->validated();
            $employeeUser = new EmployeeUser;
            $employeeUser->name = $request->name;
            $employeeUser->email = $request->email;
            $employeeUser->password = Hash::make($request['password']);
            $employeeUser->phone = $request->phone;
            $employeeUser->job_id = $request->other_type === 1 ? null : $request->select_job_id;
            $employeeUser->other_type = $request->other_type;
            $employeeUser->otp = $otp;
            $employeeUser->otp_expires_at = now()->addMinutes(10);
            $employeeUser->save();

            if ($request->other_type == 1) {
                $employeeJobRequest = new EmployeeJobRequest;
                $employeeJobRequest->user_id = $employeeUser->id; // Here we have put employee user id
                $employeeJobRequest->job_name = $request->job_name;
                $employeeJobRequest->save();
            }

            $document = new Document;
            $directoryPath = public_path('images/documents/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }

            if ($image = $request['adhar_card_photo']) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($directoryPath, $imageName);
                $document->adhar_card_photo = $imageName;
            }

            $document->employee_user_id = $employeeUser->id;
            $document->adhar_card_number = $request->adhar_card_number;
            $document->save();

            // DB::commit();
            if ($employeeUser) {
                Mail::to($employeeUser->email)->send(new SendMail($employeeUser,'Otp verification'));
            }
            return response()->json(['status' => true, 'message' => 'Employee created successfully!', 'data' => null], 201);

        } catch (Exception $e) {
            // DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Error creating employee: ' . $e->getMessage()], 500);
        }
    }
}
