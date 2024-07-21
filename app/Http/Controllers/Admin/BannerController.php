<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    function __construct()
    {
        $this->Model = new Banner;

        $this->columns = [
            "id",
            "title",
            "content",
            "banner_image",
            "status",

        ];
    }
    public function index()
    {

        return view('admin.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner = null;
        return view('admin.banner.add-edit', compact('banner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->content = $request->content;
        $banner->status = $request->status;

        if ($request->hasFile('banner_image')) {
            $imageName = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('images/banner/'), $imageName);
            $banner->banner_image = $imageName;
        }
        $banner->save();

        $notification = array(
            'message' => 'Banner created successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('banners.index')->with($notification);

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

        $banner = Banner::findOrFail($id);

        return view('admin.banner.add-edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);
        $banner = Banner::findOrFail($id);
        $banner->title = $request->title;
        $banner->content = $request->content;
        $banner->status = $request->status;
        
        if ($request->hasFile('banner_image')) {
            
            if ($banner->banner_image && file_exists(public_path('images/banner/' . $banner->banner_image))) {
                unlink(public_path('images/banner/' . $banner->banner_image));
            }
            $imageName = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('images/banner'), $imageName);
            $banner->banner_image = $imageName;
        }
        $banner->save();
        $notification = array(
            'message' => 'Banner updated successfully!.',
            'alert-type' => 'success'
        );

        return redirect()->route('banners.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
    public function bannerAjax(Request $request)
    {
        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchBanner($request, $this->columns);
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
            $data['title'] = $value->title;
            $data['content'] = $value->content;
            // $data['banner_image'] = $value->banner_image;
            $banner_image = "<div class='table-plus'>";
            $banner_image .= "<div class='name-avatar d-flex align-items-center'>";
            $banner_image .= "<div class='avatar mr-2 flex-shrink-0'>";
            $banner_image .= "<img src='" . asset('images/banner/' . $value->banner_image) . "' class='border-radius-100 shadow' width='40' height='40' alt=''/>";
            $banner_image .= "</div>";
            $banner_image .= "</div>";
            $banner_image .= "</div>";

            if ($value->status == 1) {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='0' class='badge badge-success bannerStatus'>Active</a>";
            } else {
                $status = "<a href='javascript:void(0)' data-id='" . $value->id . "' data-status='1' class='badge badge-danger bannerStatus'>InActive</a>";
            }
            $action = "<div class='table-actions'>";
            $action .= "<a href='" . route('banners.edit', $value->id) . "' style='color: #265ed7;'><i class='icon-copy dw dw-edit2'></i></a>";
            $action .= "<a href='" . route('banners.destroy', $value->id) . "' style='color: #e95959'><i class='icon-copy dw dw-delete-3'></i></a>";
            $action .= "</div>";
            $data['banner_image'] = $banner_image;
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
    public function changeBannerStatus(Request $request)
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
