@extends('admin.auth.layouts.app')
@section('section')
    <div class="register-page-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('public/assets/vendors/images/register-page-img.png')}}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="register-box bg-white box-shadow border-radius-10">
                        <div class="wizard-content">
                            <form class="tab-wizard2 wizard-circle wizard" action="{{route('register.form')}}" method="POST">

                                <h5>Basic Account Credentials</h5>
                                <section>
                                    <div class="form-wrap max-width-600 mx-auto">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Email Address*</label>
                                            <div class="col-sm-8">
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Username*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="username">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Password*</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Confirm Password*</label>
                                            <div class="col-sm-8">
                                                <input type="password" class="form-control" name="confPassword">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h5>Personal Information</h5>
                                <section>
                                    <div class="form-wrap max-width-600 mx-auto">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Full Name*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Date Of Birth*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control date-picker" placeholder="Select Date" name="dob">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-4 col-form-label">Gender*</label>
                                            <div class="col-sm-8">
                                                <div class="custom-control custom-radio custom-control-inline pb-0">
                                                    <input type="radio" id="male" name="gender"
                                                        class="custom-control-input" value="male">
                                                    <label class="custom-control-label" for="male">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline pb-0">
                                                    <input type="radio" id="female" name="gender"
                                                        class="custom-control-input" value="female">
                                                    <label class="custom-control-label" for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox mt-4">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="accept_terms_and _condition">
                                            <label class="custom-control-label" for="customCheck1">I have read and agreed to
                                                the terms of services and privacy policy</label>
                                        </div>

                                    </div>
                                </section>
                                <!-- Step 3 -->

                                <!-- Step 4 -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- success Popup html Start -->
    {{-- <button type="button" id="success-modal-btn" hidden data-toggle="modal" data-target="#success-modal"
        data-backdrop="static">Launch modal</button>
    <div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered max-width-400" role="document">
            <div class="modal-content">
                <div class="modal-body text-center font-18">
                    <h3 class="mb-20">Form Submitted Successfully!</h3>
                    <div class="mb-30 text-center"><img src="{{ asset('public/assets/vendors/images/success.png')}}"></div>
                   
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="login.html" class="btn btn-primary">Done</a>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
