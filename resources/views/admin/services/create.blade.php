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
                                <li class="breadcrumb-item active" aria-current="page">{{$services ? 'Edit Services' : 'Add Services'}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('services.index')}}">
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
                <form action="{{ $services ? route('services.update', $services->id) : route('services.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if($services)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Select Job <span style="color:red">*</span> </label>
                                <select class="form-control" required name="job_id">
                                    <option value="">Select Job</option>
                                    @foreach ($getJob as $value)
                                        <option value="{{$value->id}}">{{$value->job_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name<span style="color:red">*</span> </label>
                                <input class="form-control" required aria-errormessage="Please Enter Name" type="text" name="name" placeholder="name"
                                    value="{{ $services ? $services->name : null}}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ $services != null && $services->status == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ $services != null && $services->status == 0 ? 'selected' : '' }}>Inactive
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                    placeholder="description">{{ $services ? $services->description : null}}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary btn-lg">{{ $services ? 'Update' : 'Create' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

@endsection
