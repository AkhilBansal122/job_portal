<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class JobCategory extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_category_id');
    }

    public function fetchJobCategory($request, $columns) {
        $query =JobCategory::where('job_category_name', '!=', '');

        if (isset($request->from_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") >= "' . date("Y-m-d", strtotime($request->from_date)) . '"');
        }
        if (isset($request->end_date)) {
            $query->whereRaw('DATE_FORMAT(created_at, "%Y-%m-%d") <= "' . date("Y-m-d", strtotime($request->end_date)) . '"');
        }

        if (isset($request['search']['value'])) {
            $query->where(function ($q) use ($request) {
                $q->where('job_category_name', 'like', '%' . $request['search']['value'] . '%');
            });
        }
        if (isset($request->status)) {
            $query->where('status', $request->status);
        }

        if (isset($request->order_column)) {
            $categories = $query->orderBy($columns[$request->order_column], $request->order_dir);
        } else {
            $categories = $query->orderBy('created_at', 'desc');
        }
        return $categories;
    }
}
