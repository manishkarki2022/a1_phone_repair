<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ websiteInfo()->website_name }} - @yield('title', 'Default Title')</title>
       <link rel="icon" type="image/png" sizes="128*128" href="{{ websiteInfo() && websiteInfo()->first() && websiteInfo()->logo_path ? asset('/storage/' . websiteInfo()->first()->logo_path) : asset('default/website-16x16.png') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <style>
        .login-page {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
        }
        .login-logo a {
            color: #fff;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .login-card {
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border: none;
        }
        .login-card-body {
            border-radius: 10px;
        }
        .input-group-text {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- Login logo -->
    <div class="login-logo mb-4">
        <a href="{{ url('/') }}"><b>{{ websiteInfo()->website_name }} - @yield('title', 'Default Title')</b></a>
    </div>

    <!-- Card -->
    <div class="card login-card">
        <div class="card-body login-card-body">
            @yield('content')
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
    });
});
</script>
</body>
</html>
