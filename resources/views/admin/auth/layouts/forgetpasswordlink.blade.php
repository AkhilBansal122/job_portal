@extends('admin.auth.layouts.app')
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
<style>
    .toggle-password {
    float: right;
    cursor: pointer;
    margin-right: 10px;
    margin-top: -25px;
}
</style>
@endpush
@section('content')
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('public/assets/vendors/images/login-page-img.png') }}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Reset Password</h2>
                        </div>
                        <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  <!-- <i class="toggle-password fa fa-fw fa-eye-slash"></i> -->
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  <!-- <i class="toggle-password fa fa-fw fa-eye-slash"></i> -->
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Reset Password
                              </button>
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
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









