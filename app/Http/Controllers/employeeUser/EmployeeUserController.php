<?php

namespace App\Http\Controllers\employeeUser;

use App\Http\Controllers\Controller;
use App\Models\EmployeeUser;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\EmployeeJobRequest;

class EmployeeUserController extends Controller
{
    function __construct()
    {
        $this->Model = new EmployeeUser;

        $this->columns = [
            "id",
            "name",
            "email",
            "approvalStatus",
            "phone",
            "status",

        ];
    }
    public function index()
    {
        return view('admin.employee-users.index');
    }
    public function show($id)
    {
        $employeeUser = EmployeeUser::find($id);
        return view('admin.employee-users.view', compact('employeeUser'));
    }
    public function changeEmployeeUserApprovalStatus(Request $request)
    {

        $employee_uses = $this->Model->where('id', $request->id)->first();

        if (isset($employee_uses) && $employee_uses->other_type == 1 && $request->status == 1) {

            $check = EmployeeJobRequest::where("user_id", $employee_uses->id)->first();
            if ($check) {
                Job::create([
                    'job_name' => $check->job_name,
                ]);
            }
            $check->status_approval = $request->status;
            $check->save();
        } else {
            $check = EmployeeJobRequest::where("user_id", $employee_uses->id)->first();
            $check->status_approval = $request->status;
            $check->save();
        }
        $employee_uses->approvalStatus = $request->status;
        if ($employee_uses) {
            $msg = null;
            if ($request->status == 1) {
                $msg .= "Approved";
            } elseif ($request->status == 2) {
                $msg .= "Reject";
            }
            $employee_uses->approvalStatus = $request->status;
            $employee_uses->save();

            // if ($employee_uses->other_type == 1) {
            //     $check = EmployeeJobRequest::where("user_id", $employee_uses->id)->first();

            //     if ($request->status == 1) {
            //         $job = Job::create([
            //             'job_name' => ucwords(strtolower($check->job_name)),
            //         ]);
            //         $employee_uses->job_id = $job->id;
            //         $employee_uses->save();
            //         $check->status_approval = $request->status;
            //         $check->save();
            //     }
            // }
            if ($employee_uses) {
                return json_encode([
                    'status' => true,
                    "message" => $msg . " Successfully"
                ]);
            } else {
                return json_encode([
                    'status' => false,
                    "message" => "Status Changes Fails"
                ]);
            }
        }

    }


    public function employeeUsersAjax(Request $request)
    {

        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchEmployeeUser($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $categories = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $categories = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = 1;
        foreach ($categories as $value) {
            $data = [];
            $data['id'] = $value->id;

            $data['name'] = $value->name;
            $data['email'] = $value->email;
            $data['number'] = $value->phone;

            if ($value->approvalStatus == 0) {
                $dropdownToggleRestriction = "data-toggle='dropdown'";

            } else {
                $dropdownToggleRestriction = null;
            }
            $status_class = '';
            $status_text = '';
            switch ($value->approvalStatus) {
                case 1:
                    $status_class = 'success';
                    $status_text = 'Approved';
                    break;
                case 0:
                    $status_class = 'warning';
                    $status_text = 'Pending';
                    break;
                case 2:
                    $status_class = 'danger';
                    $status_text = 'Rejected';
                    break;
                default:
                    $status_class = 'secondary';
                    $status_text = 'Unknown';
                    break;
            }

            $status_approval = "<div class='dropdown'>";
            $status_approval .= "<button class='btn btn-sm btn-$status_class dropdown-toggle' type='button' id='dropdownMenuButton_" . $value->id . "' " . $dropdownToggleRestriction . " aria-haspopup='true' aria-expanded='false'>";
            $status_approval .= $status_text;
            $status_approval .= "</button>";
            $status_approval .= "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton_" . $value->id . "'>";
            $status_approval .= "<a class='dropdown-item changeEmployeeUserApprovalStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='1'>Approved</a>";
            $status_approval .= "<a class='dropdown-item changeEmployeeUserApprovalStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='0'>Pending</a>";
            $status_approval .= "<a class='dropdown-item changeEmployeeUserApprovalStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='2'>Rejected</a>";
            $status_approval .= "</div>";
            $status_approval .= "</div>";


            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success employeeUserStatus'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger employeeUserStatus'>InActive</a>";
            }
            $view = "<a href='" . route('employee-users.show', $value->id) . "' data-status='1' class='badge badge-secondary userStatus'>View</a>";

            $data['view'] = $view;
            $data['status_approval'] = $status_approval;
            $data['status'] = $status;
            $result[] = $data;

        }
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }
    public function changeEmployeeUserStatus(Request $request)
    {
        $response = $this->Model->where('id', $request->id)->update(['status' => $request->status]);
        if ($response) {
            return json_encode([
                'status' => true,
                "message" => "Status Changes Successfully"
            ]);
        } else {
            return json_encode([
                'status' => false,
                "message" => "Status Changes Fails"
            ]);
        }
    }
}
