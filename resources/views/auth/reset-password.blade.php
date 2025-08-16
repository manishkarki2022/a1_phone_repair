@extends('layout.guest')

@section('title', 'Reset Password')

@section('content')
<div class="text-center mb-4">
    <img src="{{ asset('assets/img/reset-password.svg') }}" alt="Reset Password" class="auth-image" style="max-height: 150px;">
    <h4 class="mt-3 font-weight-bold"><i class="fas fa-key mr-2"></i> Reset Your Password</h4>
    <p class="text-muted">Enter your email and new password below</p>
</div>

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Field -->
    <div class="form-group mb-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Your email address"
                   value="{{ old('email', $request->email) }}"
                   required
                   autofocus>
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password Field -->
    <div class="form-group mb-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="New password"
                   required>
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- Confirm Password Field -->
    <div class="form-group mb-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm new password"
                   required>
        </div>
    </div>

    <div class="form-group mb-4">
        <button type="submit" class="btn btn-primary btn-block btn-gradient-primary py-3">
            <i class="fas fa-redo mr-2"></i> Reset Password
        </button>
    </div>
</form>

<div class="text-center">
    <p class="mb-0">
        <a href="{{ route('login') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left mr-1"></i> Back to Login
        </a>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resetPasswordForm');
    form.addEventListener('submit', function() {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Resetting...';
    });
});
</script>
@endsection
