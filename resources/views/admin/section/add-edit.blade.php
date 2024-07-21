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
                                <li class="breadcrumb-item active" aria-current="page">Section</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('section.index')}}">
                                View
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
                <form action="{{route('section.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Section Name</label>
                                <input class="form-control" type="text" name="section_name" placeholder="Section Anme"
                                    value="{{old('section_name')}}">
                                @error('section_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Section Image</label>
                                <input class="form-control" type="file" name="section_image"
                                    placeholder="Section Image">
                                @error('section_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Section Discount</label>
                                <input class="form-control" type="number" name="section_discount"
                                    placeholder="Section Discount" value="{{old('section_discount')}}">
                                @error('section_discount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input class="form-control" type="text" name="meta_title" placeholder="Meta Title"
                                    value="{{old('meta_title')}}">
                                @error('meta_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Meta Description</label>
                                <input class="form-control" type="text" name="meta_description"
                                    placeholder="Meta Description" value="{{old('meta_description')}}">
                                @error('meta_description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input class="form-control" type="text" name="meta_keywords" placeholder="Meta Keywords"
                                    value="{{old('meta_keywords')}}">
                                @error('meta_keywords')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description"
                                    placeholder="description">{{old('description')}}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

@endsection