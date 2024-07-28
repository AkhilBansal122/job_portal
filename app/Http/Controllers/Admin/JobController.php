<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Validation\Rule;


class JobController extends Controller
{
    function __construct()
    {
        $this->Model = new Job;

        $this->columns = [
            "id",
            "job_name",
            "description",
            "status",
            "action",
        ];
    }
    public function index()
    {
        return view('admin.job.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobCategories = JobCategory::where("status",1)->get();
        $job = null;
        return view('admin.job.add-edit', compact('jobCategories', 'job'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'job_name' => 'required|string|max:255|unique:user_jobs,job_name',
            'status' => 'required|in:0,1',
            'job_category' => 'required|exists:job_categories,id',
            'description' => 'nullable|string|max:1000',

        ]);

        // Create a new job category
        Job::create([
            'job_name' => $request->input('job_name'),
            'job_category_id' => $request->input('job_category'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        $notification = array(
            'message' => 'Job created successfully!.',
            'alert-type' => 'success'
        );
        return redirect()->route('jobs.index')->with($notification);
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
        $jobCategories = JobCategory::where("status",1)->get();
        $job = Job::findOrFail($id);
        return view('admin.job.add-edit', compact('jobCategories', 'job'));
    }

    /**
     * Update the specified resource in storage.
     */

    //  if($request){
    //     Job::where('job_name', $request->job_name)
    //  }
    public function update(Request $request, string $id)
    {

        $request->validate([
            'job_name' => ['required','string','max:255',
                Rule::unique('user_jobs')->ignore($id),
            ],
            'status' => 'required|in:0,1',
            'job_category' => 'required|exists:job_categories,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $job = Job::findOrFail($id);
        $job->update([
            'job_name' => $request->input('job_name'),
            'job_category_id' => $request->input('job_category'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        $notification = array(
            'message' => 'Job updated successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('jobs.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        dd('ddddd');
        $job = Job::findOrFail($id)->delete();
        $notification = array(
            'error' => 'Job deleted successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('jobs.index')->with($notification);
    }
    public function jobAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchJob($request, $this->columns);
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

            $data['job_name'] = $value->job_name;
            $data['job_category_name'] = $value->jobCategory->job_category_name ?? 'N/A';
            $data['description'] = $value->description;
            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success selectJob'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger selectJob'>InActive</a>";
            }
            $action = "<div class='table-actions'>";
            $action .= "<a href='" . route('jobs.edit', $value->id) . "' style='color: #265ed7;'><i class='icon-copy dw dw-edit2'></i></a>";
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
    public function changeJobStatus(Request $request)
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
