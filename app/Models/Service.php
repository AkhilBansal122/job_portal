<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class Service extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function getSelectJob(){
        return $this->belongsTo(Job::class,'job_id');
    }
    public function fetchServices($request, $columns) {
        $query =Service::where('name', '!=', '');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request['search']['value'] . '%');
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
