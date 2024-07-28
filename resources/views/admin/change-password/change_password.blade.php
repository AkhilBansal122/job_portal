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
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Change Password') }}
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
                <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Old Password</label>
                                <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                    placeholder="Old Password"><i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                    	        </div>

                            <div class="mb-3">
                                <label for="newPasswordInput" class="form-label">New Password</label>
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                    placeholder="New Password"><i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                                <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput"
                                    placeholder="Confirm New Password"><i class="toggle-password fa fa-fw fa-eye-slash"></i>
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
@push('script')
<script>
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
</script>
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
