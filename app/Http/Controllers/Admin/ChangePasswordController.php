<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    function __construct()
    {
        $this->Model = new JobCategory;

        $this->columns = [

        ];
    }
    public function index()
    {
        return view('admin.change-password.change_password');
    }
    public function updatePassword(Request $request)
    {
            # Validation
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);
            // dd(auth()->user());
            $user = auth()->user();
            # Match The Old Password
            if(!Hash::check($request->old_password, $user->password)){
                // return back()->with("error", "Old Password Doesn't match!");
                $notification = array(
                    'message' => 'Old Password Doesnt match',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            }

             # Check if the new password is the same as the old password
            if (Hash::check($request->new_password, $user->password)) {
                // return back()->with("error", "New Password cannot be the same as the old password!");
                $notification = array(
                    'message' => 'New Password cannot be the same as the old password',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            }

            # Update the new Password
            $user->password  =Hash::make($request->new_password);
            if($user->save()){
              //  return back()->with("status", "Password changed successfully!");
                $notification = array(
                    'message' => 'Password change successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Password change failed',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);

            }


    }


}
