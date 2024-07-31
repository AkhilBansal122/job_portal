@extends('admin.auth.layouts.app')
@section('content')
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<img src="{{ asset('public/assets/vendors/images/forgot-password.png')}}" alt="">
				</div>
				<div class="col-md-6">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Forgot Password</h2>
						</div>
						<h6 class="mb-20">Enter your email address to reset your password</h6>
						<form action="{{ route('admin.resetPassword') }}" method="post">
						@csrf
						   @error('email')
                             <span class="text-danger">{{ $message }}</span>
                            @enderror
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Email" name="email">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
								</div>
							</div>
							<div class="row align-items-center">
								<div class="col-5">
									<div class="input-group mb-0">

											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

									</div>
								</div>
								<div class="col-2">
									<div class="font-16 weight-600 text-center" data-color="#707373">OR</div>
								</div>
								<div class="col-5">
									<div class="input-group mb-0">
										<a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('admin.login')}}">Login</a>
									</div>
								</div>
							</div>
						</form>
					</div>
					<h6 class="mb-20">Enter your email address to reset your password</h6>
					<form action="{{ route('admin.resetPassword') }}" method="post">
						@csrf
						@error('email')
							<span class="text-danger">{{ $message }}</span>
						@enderror
						<div class="input-group custom">
							<input type="text" class="form-control form-control-lg" placeholder="Email" name="email">
							<div class="input-group-append custom">
								<span class="input-group-text"><i class="fa fa-envelope-o"
										aria-hidden="true"></i></span>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-5">
								<div class="input-group mb-0">

									<input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">

								</div>
							</div>
							<div class="col-2">
								<div class="font-16 weight-600 text-center" data-color="#707373">OR</div>
							</div>
							<div class="col-5">
								<div class="input-group mb-0">
									<a class="btn btn-outline-primary btn-lg btn-block"
										href="{{ route('admin.login')}}">Login</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
