<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('admin.userprofile.user_profile');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        {
            $request->validate([
                'name' => 'required',
                'phone_number' => 'required|numeric|digits_between:10,15',
            ]);

            $input = $request->all();
            $user = auth('admin')->user();
            if ($request->hasFile('profile_image')) {
                // Check if there is an existing profile image and delete it
                if ($user->profile_image) {
                    $oldImage = public_path('/profileimage') . '/' . $user->profile_image;
                    if (file_exists($oldImage)) {
                        @unlink($oldImage);
                    }
                }

                // Upload new profile image
                $avatarName = time() . '.' . $request->profile_image->getClientOriginalExtension();
                $request->profile_image->move(public_path('profileimage'), $avatarName);

                $input['profile_image'] = $avatarName;
            } else {
                unset($input['profile_image']);
            }

            auth('admin')->user()->update($input);

            $notification = array(
                'message' => 'Profile updated successfully',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
    }
}