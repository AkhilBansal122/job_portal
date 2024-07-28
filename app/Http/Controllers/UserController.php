<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function __construct()
    {
        $this->Model = new User;

        $this->columns = [
            "id",
            "name",
            "email",
            "phone_number",
            "status",

        ];
    }
    public function index()
    {
        return view('admin.users.index');
    }
    public function show($id)
    {
        $user=User::find($id);
        return view('admin.users.view', compact('user'));
    }
    public function userAjax(Request $request)
    {

        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchUser($request, $this->columns);
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
            $data['number'] = $value->phone_number;
            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success userStatus'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger userStatus'>InActive</a>";
            }
            $view = "<a href='" . route('users.show', $value->id) . "' data-status='1' class='badge badge-secondary'>View</a>";

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
    public function changeUserStatus(Request $request)
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
