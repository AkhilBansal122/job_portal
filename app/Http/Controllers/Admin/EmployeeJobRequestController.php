<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeJobRequest;
class EmployeeJobRequestController extends Controller
{
    function __construct()
    {
        $this->Model = new EmployeeJobRequest;
        $this->imagePath  =public_path('images/services/');
        $this->columns = [
            "id",
            "job_id",
            "name",
            "image",
            "status",
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
    public function destroy(string $id)
    {
        //
    }
    public function employeeJobRequestAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchServices($request, $this->columns);
        $total = $records->get();
        if (isset($request->start)) {
            $banners = $records->offset($request->start)->limit($request->length)->get();
        } else {
            $banners = $records->offset($request->start)->limit(count($total))->get();
        }
        $result = [];
        $i = 1;
        foreach ($banners as $value) {
            $data = [];
            $data['id'] = $value->id;
            $data['name'] =ucfirst($value->name) ;
            $data['job_id'] = ucfirst($value->getSelectJob->job_name) ?? '';
            $data['image'] = "<img height='100' width='100' src='".asset('images/services/')."/".$value->image."'/>";
            $data['description'] = $value->description;
            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success servicesStatus'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger servicesStatus'>InActive</a>";
            }
            $action = "<div class='table-actions'>";
            $action .= "<a href='" . route('services.edit', $value->id) . "' style='color: #265ed7;'><i class='icon-copy dw dw-edit2'></i></a>";
            $action .= "</div>";
            $data['action'] = $action;
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
}
