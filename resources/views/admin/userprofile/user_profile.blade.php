@extends('admin.layouts.app')
@push('style')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<style>
		/ Custom Toastr Styles /
		#toast-container>div {
			background-color: brown;
			/ Dark background color /
			color: #fff;
			/ Light text color /
			box-shadow: none;
			/ Remove shadow /
			border: none;
		}

		#toast-container>div.toast-success {
			background-color: green;
			/ Success messages background color /
			background-color: green;
			transition: background-color 0.3s ease;
		}

		#toast-container>div.toast-error {
			background-color: #d9534f;
			/ Error messages background color /
		}

		#toast-container>div.toast-info {
			background-color: #5bc0de;
			/ Info messages background color /
		}

		#toast-container>div.toast-warning {
			background-color: #f0ad4e;
			/ Warning messages background color /
		}
	
        .toggle-password {
        float: right;
        cursor: pointer;
        margin-right: 10px;
        margin-top: -25px;
        }
    </style>
@endpush
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
                                <li class="breadcrumb-item active" aria-current="page">User Profile
                                </li>
                            </ol>
                        </nav>
                    </div>
                    
                </div>
            </div>

            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <!-- <h4 class="text-blue h4">Add Task</h4> -->
                    </div>
                </div>
                <form action="{{ route('user.profile.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" placeholder="name"
                                value="{{ auth()->user()->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" placeholder="mobile number"
                                value="{{ auth()->user()->phone_number }}">
                                @error('phone_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Image</label>
                                <input id="profile_image" type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" value="{{ old('profile_image') }}"  autocomplete="profile_image">
  
                                @error('profile_image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <img src="/profileimage/{{ auth()->user()->profile_image }}" style="width:80px;margin-top: 10px;">
                            </div>
                        </div>
                        
                       

                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary btn-lg"> {{ __('Update Profile') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

@endsection
@push('script')
<script>
			@if (Session::has('message'))
				var type = "{{ Session::get('alert-type', 'info') }}"
				switch (type) {
					case 'info':
						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.info("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();
						break;
					case 'success':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.success("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();

						break;
					case 'warning':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.warning("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();

						break;
					case 'error':

						toastr.options.timeOut = 10000;
						toastr.options =
						{
							"closeButton": true,
							"progressBar": true,
						}
						toastr.error("{{ Session::get('message') }}");
						var audio = new Audio('audio.mp3');
						audio.play();
						break;
				}
			@endif
		</script>
@endpush
