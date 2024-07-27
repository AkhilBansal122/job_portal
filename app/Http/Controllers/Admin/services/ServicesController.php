<?php

namespace App\Http\Controllers\Admin\services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Service;
use File;

class ServicesController extends Controller
{
    function __construct()
    {
        $this->Model = new Service;
        $this->imagePath = public_path('images/services/');
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
        $getJob = Job::where('status', 1)->get();
        $services = null;
        return view('admin.services.create', compact('getJob', 'services'));
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
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $checked = Service::where(['job_id' => $request->job_id, 'name' => $request->name])->first();
            if ($checked) {
                $notification = array(
                    'message' => 'services name already exists.',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
            $image = "";
            $directoryPath = public_path('images/services/');

            // Check if the directory exists
            if (!File::exists($directoryPath)) {
                // Create the directory
                File::makeDirectory($directoryPath, 0755, true);
            }
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/services/'), $imageName);
                $image = $imageName;
            }
            // Create a new job category
            Service::create([
                'job_id' => $request->input('job_id'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'image' => $image
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
        $getJob = Job::where('status', 1)->get();
        $services = Service::findOrFail($id);
        ;
        return view('admin.services.edit', compact('getJob', 'services'));
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

        $services = Service::findOrFail($id);
        if ($services) {
            $checked = Service::where(['job_id' => $request->job_id, 'name' => $request->name])->where("id", "!=", $services->id)->first();

            if ($checked) {
                $notification = array(
                    'message' => 'services nam  is already exist.',
                    'alert-type' => 'success'
                );
                return redirect() - back()->with($notification);

            }
            $directoryPath = public_path('images/services/');

            // Check if the directory exists
            if (!File::exists($directoryPath)) {
                // Create the directory
                File::makeDirectory($directoryPath, 0755, true);
            }
            $image = '';
            if ($request->hasFile('image')) {
                if ($services->image && file_exists(public_path('images/services/' . $services->image))) {
                    unlink(public_path('images/services/' . $services->image));
                }
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/services/'), $imageName);
                $image = $imageName;
            } else {
                $image = $services->image;
            }
            $services->update([
                'name' => $request->input('name'),
                'job_id' => $request->input('job_id'),
                'description' => $request->input('description'),
                'status' => $request->input('status'),
                'image' => $image,
            ]);

            $notification = array(
                'message' => 'services created successfully!.',
                'alert-type' => 'success'
            );


            return redirect()->route('services.index')->with($notification);

        } else {
            $notification = array(
                'message' => 'services No Record Found.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

        }
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
            $data['name'] = ucfirst($value->name);
            $data['job_id'] = $value->getSelectJob ? ucfirst($value->getSelectJob->job_name) : '';
            if ($value->image) {
                $data['image'] = "<img height='50' width='50' src='" . asset('images/services/') . "/" . $value->image . "'/>";
            } else {
                $data['image'] = "<img height='50' width='50' src='" . defaultImage() . "'/>";

            }
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
