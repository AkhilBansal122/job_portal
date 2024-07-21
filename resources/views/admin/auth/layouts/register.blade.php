@extends('admin.auth.layouts.app')
@section('content')
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center" style="min-height: 100vh; padding: 20px;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image Section -->
            <div class="col-md-6 col-lg-7 d-none d-md-block">
                <img src="{{ asset('assets/vendors/images/login-page-img.png') }}" alt="Login Page Image" class="img-fluid" style="margin-bottom: 20px;">
            </div>

            <!-- Form Section -->
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10 p-4" style="padding: 30px;">
                    <div class="login-title text-center mb-4">
                        <h2 class="text-primary">Register</h2>
                    </div>

                    <!-- Login Form -->
                    <form action="{{route('register.form')}}" method="post">
                        @csrf
                        <!-- Input Fields (2 Columns Per Row) -->
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="first-name">Full Name</label>
                                <input type="text" id="first-name" class="form-control form-control-lg" placeholder="Full Name" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="last-name">Email ID</label>
                                <input type="email" id="last-name" class="form-control form-control-lg" placeholder="Email ID" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="Password" value="{{ old('password') }}" autocomplete="off">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="password">Confirm Password</label>
                                <input type="password" id="conf_password" class="form-control form-control-lg" name="conf_password" placeholder="Confirm Password" value="{{ old('conf_password') }}" autocomplete="off">
                            </div>
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="row pb-4">
                            <div class="col-sm-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="terms_conditions">
                                    <label class="custom-control-label" for="customCheck1">Accept terms & Condition</label>
                                </div>
                            </div>
                          
                        </div>

                        <!-- Sign-In and Registration Options -->
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                                <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">OR</div>
                                <a class="btn btn-outline-primary btn-lg btn-block" href="register.html">Sign In</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection