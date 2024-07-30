@extends('admin.auth.layouts.app')
@push('style')
    <style>
        .toggle-password {
            float: right;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{ asset('assets/vendors/images/login-page-img.png') }}" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    <div class="login-title">
                        <h2 class="text-center text-primary">Login</h2>
                    </div>
                    <form action="{{ route('postLogin') }}" method="post">
                        @csrf
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="input-group custom">
                            <input type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                placeholder="Enter your email">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>

                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="input-group custom">
                            <input type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Enter your password">
                            <div class="input-group-append custom">
                                <span class="input-group-text">
                                    <i class="toggle-password fa fa-fw fa-eye-slash" id="togglePassword"></i>
                                </span>
                            </div>
                        </div>

                        <div class="row pb-30">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Remember</label>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="forgot-password"><a href="{{ route('admin.forgotPassword')}}">Forgot
                                        Password</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
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
@push('script')
    <script>
        // here view or shut the password 
        $(".toggle-password").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            let input = $(this).closest('.input-group').find('input');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>


@endpush