<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/vendors/images/apple-touch-icon.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/vendors/images/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/vendors/images/favicon-16x16.png')}}">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/core.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/icon-font.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/styles/style.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/jquery-steps/jquery.steps.css')}}"> -->
	
        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="login-page">
        @include('admin.auth.layouts.header')
        @yield('content')
        
    {{-- @include('admin.layouts.header')
	@include('admin.layouts.rightSideBar')
	@include('admin.layouts.sidebar')
	@include('admin.layouts.main')
	@include('admin.layouts.footerLinks') --}}
    <!-- js -->

    <script src="{{ asset('assets/vendors/scripts/core.js')}}"></script>
    <script src="{{ asset('assets/vendors/scripts/script.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/scripts/process.js')}}"></script>
    <script src="{{ asset('assets/vendors/scripts/layout-settings.js')}}"></script>
	<!-- <script src="{{ asset('assets/src/plugins/jquery-steps/jquery.steps.js')}}"></script> -->
	<!-- <script src="{{ asset('assets/vendors/scripts/steps-setting.js')}}"></script> -->
    </body>
</html>
