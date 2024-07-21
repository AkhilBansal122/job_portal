<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\EmployeeUser;
use App\Models\Service;



class DashboardController extends Controller
{
    public function dashboard()
    {
        // dd('ffff');
        $userCount = User::count();
        $employeeUserCount=EmployeeUser::count();
        $jobCount=Job::count();
        $jobCategoryCount=JobCategory::count();
        $service=Service::count();
        return view('admin.layouts.main', compact('userCount','employeeUserCount','jobCount','jobCategoryCount','service'));

    }
}
