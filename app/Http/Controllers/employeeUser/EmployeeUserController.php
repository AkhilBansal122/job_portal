<?php

namespace App\Http\Controllers\employeeUser;

use App\Http\Controllers\Controller;
use App\Models\EmployeeUser;
use Illuminate\Http\Request;

class EmployeeUserController extends Controller
{
    function __construct()
    {
        $this->Model = new EmployeeUser;

        $this->columns = [
            "id",
            "name",
            "email",
            "phone",
            "status",

        ];
    }
    public function index(){
        return view('admin.employee-users.index');
    }
    public function show($id){
        $employeeUser=EmployeeUser::find($id);
        return view('admin.employee-users.view', compact('employeeUser'));
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
            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success employeeUserStatus'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger employeeUserStatus'>InActive</a>";
            }
            $view = "<a href='" . route('employee-users.show', $value->id) . "' data-status='1' class='badge badge-secondary userStatus'>View</a>";

            $data['view'] = $view;
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
