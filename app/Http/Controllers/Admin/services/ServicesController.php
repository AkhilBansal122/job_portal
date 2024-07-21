<?php

namespace App\Http\Controllers\Admin\services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Service;
class ServicesController extends Controller
{
    function __construct()
    {
        $this->Model = new Service;

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
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getJob = Job::where('status',1)->get();
        $services = null;
        return view('admin.services.create',compact('getJob','services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'job_id' => 'required',
                'description' => 'nullable|string|max:1000',

            ]);

            // Create a new job category
            Service::create([
                'job_id' => $request->input('job_id'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
            ]);

            $notification = array(
                'message' => 'services created successfully!.',
                'alert-type' => 'success'
            );

            return redirect()->route('services.index')->with($notification);


        } catch (\Throwable $th) {
            dd($th);
        }
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
        $getJob = Job::where('status',1)->get();
        $services = Service::findOrFail($id);
        return view('admin.services.edit',compact('getJob','services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'job_id' => 'required|exists:user_jobs,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $job = Service::findOrFail($id);
        $job->update([
            'name' => $request->input('name'),
            'job_id' => $request->input('job_id'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        $notification = array(
            'message' => 'services created successfully!.',
            'alert-type' => 'success'
        );


        return redirect()->route('services.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function servicesAjax(Request $request)
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

            $data['name'] = $value->name;
            $data['job_id'] = $value->job_id;
            $data['image'] = $value->image;
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
    public function changeServicesStatus(Request $request)
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
