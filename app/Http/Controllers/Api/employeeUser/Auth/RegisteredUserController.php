<?php

namespace App\Http\Controllers\Api\employeeUser\Auth;

use App\Http\Controllers\Controller;
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

class RegisteredUserController extends Controller
{
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
        $validatedData = $request->validated();
        $employeeUser = new EmployeeUser;
        $employeeUser->name=$request->name;
        $employeeUser->email=$request->email;
        $employeeUser->password=Hash::make($request['password']);
        $employeeUser->phone=$request->phone;
        $employeeUser->job_id=$request->select_job_id;
        if($request->other_type==1){
            dd('if');
            $employeeUser->other_type=$request->other_type;
            $employeeUser->job_name=$request->job_name;
        }
      
dd('bahar');
        $directoryPath = public_path('images/services/');

                // Check if the directory exists
                if (!File::exists($directoryPath)) {
                    // Create the directory
                    File::makeDirectory($directoryPath, 0755, true);
                }
        if ($image = $request['profile_image']) {
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('images/employeeUser', $imageName);
        }
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = EmployeeUser::create($validatedData);
        
        return response()->json(['status' => true, 'message' => 'Employee created successfully!', 'data' => $user], 201);



        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
    }
}
