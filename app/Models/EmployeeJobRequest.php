<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\EmployeeUser;
class EmployeeJobRequest extends Model
{
    use HasFactory;
    protected $table = "employee_job_requests";
    protected $guarded =[];



    public function getEmployee(){
        return $this->belongsTo(EmployeeUser::class,"user_id");
    }
    public function getSelectJob(){
        return $this->belongsTo(Job::class,"user_id");
    }
    public function fetchJobRequest($request, $columns) {
        $query =EmployeeJobRequest::where('id', '!=', '');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('other_value', 'like', '%' . $request['search']['value'] . '%');
            });
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        if (isset($request->order_column)) {
            $banners = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $banners = $query->orderBy('created_at', 'desc');
        }
        return $banners;
    }
}
