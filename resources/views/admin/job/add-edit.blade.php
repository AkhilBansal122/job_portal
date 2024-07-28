@extends('admin.layouts.app')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <!-- <h4>@if(isset($task) && !empty($task)) {{$task->heading}} @else Add Task @endif</h4> -->
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$job ? 'Edit Job' : 'Add Job'}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('jobs.index')}}">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <!-- <h4 class="text-blue h4">Add Task</h4> -->
                    </div>
                </div>
                <form action="{{ $job ? route('jobs.update', $job->id) : route('jobs.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if($job)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Job Name<span style="color:red">*</span></label>
                                <input class="form-control" type="text" name="job_name" placeholder="Enter Job Name"
                                    value="{{ $job ? $job->job_name : null}}">
                                @error('job_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Job Category<span style="color:red">*</span></label>
                                <select required class="form-control" name="job_category">
                                <option value="">Select Job Category</option>
                                    @foreach ($jobCategories as $value)
                                        <option value="{{$value->id}}" @if(isset($job->job_category_id) && $job->job_category_id == $value->id) selected @endif >{{$value->job_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ $job != null && $job->status == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ $job != null && $job->status == 0 ? 'selected' : '' }}>Inactive
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                    placeholder="Enter Description">{{ $job ? $job->description : null}}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary btn-lg">{{ $job ? 'Update' : 'Create' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

@endsection
