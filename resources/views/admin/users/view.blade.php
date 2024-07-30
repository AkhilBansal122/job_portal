@extends('admin.layouts.app')

@section('content')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>User Data</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    User Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <div class="dropdown no-arrow">
                            <a class="btn btn-secondary dropdown-toggle no-arrow" href="{{route('users.index')}}"
                                data-toggle="dropdown2">
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
                        <p>{{ $user->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Email:</strong></p>
                        <p>{{ $user->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Phone Number:</strong></p>
                        <p>{{ $user->phone_number }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Profile Image:</strong></p>
                        <img src="{{ asset('images/user/' . $user->profile_image) }}" alt="{{ $user->name }}"
                            class="img-fluid rounded-circle" width="80">
                    </div>
                    <div class="col-md-4">
                        <p><strong>Status:</strong></p>
                        <p style="color: {{ $user->status ? 'green' : 'red' }};">
                            {{ $user->status ? 'Active' : 'Inactive' }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <p><strong>Longitude:</strong></p>
                        <p>{{ $user->longitude }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Latitude:</strong></p>
                        <p>{{ $user->latitude }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Address:</strong></p>
                        <p>{{ $user->address }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Country:</strong></p>
                        <p>{{ $user->country }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>State:</strong></p>
                        <p>{{ $user->state }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>City:</strong></p>
                        <p>{{ $user->city }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Pincode:</strong></p>
                        <p>{{ $user->pincode }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>ID Proof:</strong></p>
                        <a href="{{ asset('images/user/' . $user->profile_image) }}" target="_blank">View ID Proof</a>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.footer')
    </div>
</div>
@endsection