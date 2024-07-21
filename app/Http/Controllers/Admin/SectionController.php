<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Str;
use App\Http\Requests\SectionRequest;
use App\Repositories\Interfaces\SectrionRepositoryInterface;


class SectionController extends Controller
{
    private $sectionRepository;
    function __construct(SectrionRepositoryInterface $sectionRepository)
    {
        $this->Model = new Section;

        $this->columns = [
            "id",
            "section_name",
            "status",
            "action",
        ];
        $this->sectionRepository = $sectionRepository;

    }
    public function index()
    {
        $section = $this->sectionRepository->index();
        return view('admin.section.index')->with('section', $section);
    }
    public function create()
    {
        return view('admin.section.add-edit');
    }
    public function store(Request $request)
    {
        $data = [
            'section_name' => $request->section_name,
            'section_slug' => str::slug($request->section_name),
            'section_image' => $request->section_image,
            'section_discount' => $request->section_discount,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_kaywords' => $request->meta_keywords,
            'status' => $request->status,
            'description' => $request->description,
        ];
        // dd($data);
        $storeSection = $this->sectionRepository->store($data);
        if (!empty($storeSection)) {
            return redirect()->route('section.index')->with('success', "Record created successfully!.");
        } else {
            return back();
        }
    }

    public function getData(Request $request)
    {
        $columns = ['id', 'section_name', 'created_at', 'updated_at'];
        $length = $request->input('length');
        $start = $request->input('start');
        $column = $request->input('order.0.column'); // Index
        $dir = $request->input('order.0.dir'); // asc or desc
        $searchValue = $request->input('search')['value'];

        $query = Section::select('id', 'section_name', 'created_at', 'updated_at')
            ->orderBy($columns[$column], $dir);
        $totalData = $query->count();

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('section_name', 'like', '%' . $searchValue . '%');
            });
        }

        $totalFiltered = $query->count();
        $sections = $query->offset(10)
            ->limit(10)
            ->get();

        $data = [];
        foreach ($sections as $section) {
            $nestedData = [];
            $nestedData['id'] = $section->id;
            $nestedData['section_name'] = $section->section_name;
            $nestedData['created_at'] = $section->created_at->format('Y-m-d H:i:s');
            $nestedData['updated_at'] = $section->updated_at->format('Y-m-d H:i:s');
            $data[] = $nestedData;
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
    public function sectionAjax(Request $request)
    {

        $request->search = $request->search;
        if (isset($request->order[0]['column'])) {
            $request->order_column = $request->order[0]['column'];
            $request->order_dir = $request->order[0]['dir'];
        }
        $records = $this->Model->fetchCaregory($request, $this->columns);
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

            $data['section_name'] = $value->section_name;
            if($value->status==1){
                $status="<a href='javascript:void(0)' data-id='".$value->id."' data-status='0' class='badge badge-success selectstatus'>Active</a>";
            }else{
                $status="<a href='javascript:void(0)' data-id='".$value->id."' data-status='1' class='badge badge-danger selectstatus'>InActive</a>";
            }
            $action = "<div class='table-actions'>";
            $action .= "<a href='' style='color: #265ed7;'><i class='icon-copy dw dw-edit2'></i></a>";
            $action .= "<a href='' style='color: #e95959'><i class='icon-copy dw dw-delete-3'></i></a>";
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

    function changeStatus(Request $request){
      
       $response =  $this->Model->where('id',$request->id)->update(['status'=>$request->status]);
        if($response){
            return json_encode([
                'status'=>true,
                "message"=>"Status Changes Successfully"
            ]);
        }
        else{
            return json_encode([
                'status'=>false,
                "message"=>"Status Changes Fails"
            ]);
        }
    }


}
