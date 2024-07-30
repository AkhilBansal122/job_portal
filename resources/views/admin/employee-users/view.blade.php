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
                            <a class="btn btn-secondary dropdown-toggle no-arrow"
                                href="{{route('employee-users.index')}}" data-toggle="dropdown2">
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
                        <img src="{{ asset('images/employeeUser/' . $employeeUser->profile_image) }}"
                            alt="{{ $employeeUser->name }}" class="img-fluid rounded-circle" width="80">
                    </div>

                    <div class="col-md-4">
                        <p><strong>Status:</strong></p>
                        <p
                            style="display: inline-block; background-color: {{ $employeeUser->status ? 'green' : 'red' }}; color: white; padding: 2px 8px; border-radius: 5px; text-align: center; cursor: pointer;">
                            {{ $employeeUser->status ? 'Active' : 'Inactive' }}
                        </p>
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
                        <a href="{{ asset('images/employeeUser/' . $employeeUser->profile_image) }}"
                            target="_blank">View ID Proof</a>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Job Request:</strong></p>
                        @if($employeeUser->other_type == 1)
                            <p>Yes</p>
                        @else
                            <p>No</p>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <p><strong>Approval Status:</strong></p>
                        @if($employeeUser->approvalStatus == 1)
                            <p
                                style="font-weight: bold; padding: 5px; border-radius: 4px; color: #28a745; background-color: #d4edda; border: 1px solid #c3e6cb; text-align: center; width: fit-content;">
                                Approved</p>
                        @elseif($employeeUser->approvalStatus == 2)
                            <p
                                style="font-weight: bold; padding: 5px; border-radius: 4px; color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; text-align: center; width: fit-content;">
                                Rejected</p>
                        @else
                            <p
                                style="font-weight: bold; padding: 5px; border-radius: 4px; color: #ffc107; background-color: #fff3cd; border: 1px solid #ffeeba; text-align: center; width: fit-content;">
                                Pending</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
</div>
@endsection