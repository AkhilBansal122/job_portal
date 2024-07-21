<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->Model = new JobCategory;

        $this->columns = [
            "id",
            "job_category_name",
            "description",
            "status",
            "action",
        ];
    }
    public function index()
    {
        return view('admin.job_category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobCategory = null;
        return view('admin.job_category.add-edit', compact('jobCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('fff');
        $request->validate([
            'job_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new job category
        JobCategory::create([
            'job_category_name' => $request->input('job_category_name'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);


        $notification = array(
            'message' => 'Category created successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('job-categories.index')->with($notification);

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
        $jobCategory = JobCategory::findOrFail($id);
        return view('admin.job_category.add-edit', compact('jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'job_category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update([
            'job_category_name' => $request->input('job_category_name'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);


        $notification = array(
            'message' => 'Category updated successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('job-categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        dd($id);
        $jobCategory = JobCategory::findOrFail($id)->delete();
        $notification = array(
            'error' => 'Category deleted successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('job-categories.index')->with($notification);
    }
    public function jobCategoryAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchJobCategory($request, $this->columns);
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

            $data['job_category_name'] = $value->job_category_name;
            $data['description'] = $value->description;
            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success selectJobCategory'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger selectJobCategory'>InActive</a>";
            }
            $action = "<div class='table-actions'>";
            $action .= "<a href='" . route('job-categories.edit', $value->id) . "' style='color: #265ed7;'><i class='icon-copy dw dw-edit2'></i></a>";

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
    public function changeJobCategoryStatus(Request $request)
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
