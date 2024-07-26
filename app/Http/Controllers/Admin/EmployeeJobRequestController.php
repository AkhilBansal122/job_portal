<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeJobRequest;
use App\Models\EmployeeUser;
use App\Models\Job;

class EmployeeJobRequestController extends Controller
{
    function __construct()
    {
        $this->Model = new EmployeeJobRequest;
        $this->columns = [
            "id",
            "user_id",
            "job_name",
            "approved_status",
            "action",
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.employeeJobRequest.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function changeJobRequestStatus(Request $request)
    {
       
        $response = EmployeeJobRequest::findOrFail($request->id);
        $response->status_approval = $request->status;
        $response->save();

        if ($response) {
            if ($request->status == 1) {
                $job = Job::create([
                    'job_name' => ucwords(strtolower($response->job_name)),
                ]);
                if ($job->id) {
                    $emp=EmployeeUser::find($response->user_id);
                    $emp->job_id=$job->id;
                    $emp->save();
                }
            }

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
    public function employeeJobRequestAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchJobRequest($request, $this->columns);

        $total = $records->get();
        // dd($total);
        if (isset($request->start)) {
            $jobRequest = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $jobRequest = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = 1;
        foreach ($jobRequest as $value) {
            $data = [];
            $data['id'] = $value->id;
            $data['user_name'] = ucfirst($value->getEmployeeUser->name);
            $data['job_name'] = ucfirst($value->job_name);

            if($value->status_approval==0){
                $dropdownToggleRestriction="data-toggle='dropdown'";
                
            }else{ 
                $dropdownToggleRestriction=null;
            }
            $status_class = '';
            $status_text = '';
            switch ($value->status_approval) {
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
            $status_approval .= "<a class='dropdown-item changeJobRequestStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='1'>Approved</a>";
            $status_approval .= "<a class='dropdown-item changeJobRequestStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='0'>Pending</a>";
            $status_approval .= "<a class='dropdown-item changeJobRequestStatus' href='javascript:void(0)' data-id='" . $value->id . "' data-status='2'>Rejected</a>";
            $status_approval .= "</div>";
            $status_approval .= "</div>";

            $data['status_approval'] = $status_approval;





            $result[] = $data;
        }
        $data = json_encode([
            'data' => $result,
            'recordsTotal' => count($total),
            'recordsFiltered' => count($total),
        ]);
        return $data;
    }
}
