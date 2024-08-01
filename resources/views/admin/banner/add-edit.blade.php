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
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{$banner ? 'Edit Banner' : 'Add Banner'}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('banners.index')}}">
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
                <form action="{{ $banner ? route('banners.update', $banner->id) : route('banners.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($banner)
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Title<span style="color:red">*</span></label>
                                <input class="form-control" type="text" name="title" placeholder="Enter banner title"
                                    value="{{ $banner ? $banner->title : null}}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Image</label>
                                <input class="form-control" type="file" accept="image/png, image/jpeg, image/jpg," name="banner_image" placeholder="Banner Image"
                                    value="{{ $banner ? $banner->banner_image : null}}">
                                @error('banner_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($banner && $banner->banner_image)
                                <img height="100" width="100" src="{{ asset('public/images/banner/' . $banner->banner_image) }}"
                                    alt="Service Image" class="img-fluid">
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                    <option value="1" {{ $banner != null && $banner->status == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ $banner != null && $banner->status == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Content<span style="color:red">*</span></label>
                                <textarea class="form-control" name="content"
                                    placeholder="Enter content">{{ $banner ? $banner->content : null}}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary btn-lg">{{ $banner ? 'Update' : 'Save' }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.layouts.footer')

    </div>
</div>


@endsection