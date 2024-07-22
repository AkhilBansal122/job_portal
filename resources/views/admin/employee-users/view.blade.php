@extends('admin.layouts.app')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Employee User Data</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Employee User Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('employee-users.index')}}" data-toggle="dropdown2">
                                Back
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Name:</strong></p>
                        <p>{{ $employeeUser->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Email:</strong></p>
                        <p>{{ $employeeUser->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Phone Number:</strong></p>
                        <p>{{ $employeeUser->phone_number }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Profile Image:</strong></p>
                        <img src="{{ asset('images/employeeUser/' . $employeeUser->profile_image) }}" alt="{{ $employeeUser->name }}" class="img-fluid rounded-circle" width="80">
                    </div>
                    <div class="col-md-4">
                        <p><strong>Status:</strong></p>
                        <p>{{ $employeeUser->status ? 'Active' : 'Inactive' }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Longitude:</strong></p>
                        <p>{{ $employeeUser->longitude }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Latitude:</strong></p>
                        <p>{{ $employeeUser->latitude }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Address:</strong></p>
                        <p>{{ $employeeUser->address }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Country:</strong></p>
                        <p>{{ $employeeUser->country }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>State:</strong></p>
                        <p>{{ $employeeUser->state }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>City:</strong></p>
                        <p>{{ $employeeUser->city }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Pincode:</strong></p>
                        <p>{{ $employeeUser->pincode }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>ID Proof:</strong></p>
                        <a href="{{ asset('images/employeeUser/' . $employeeUser->profile_image) }}" target="_blank">View ID Proof</a>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
</div>
@endsection