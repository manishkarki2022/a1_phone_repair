@extends('layout.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="text-center mb-4">
    <h4 class="mb-3"><i class="fas fa-lock-open mr-2"></i> Password Recovery</h4>
    <p class="text-muted">Enter your email to receive a reset link</p>
</div>

@if (session('status'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="icon fas fa-check-circle"></i> {{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <div class="input-group mb-3">
            <input type="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email"
                   value="{{ old('email') }}"
                   required
                   autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-paper-plane mr-2"></i> Send Reset Link
            </button>
        </div>
    </div>
</form>

<p class="mt-3 mb-1 text-center">
    <a href="{{ route('login') }}" class="text-primary">
        <i class="fas fa-arrow-left mr-1"></i> Back to Login
    </a>
</p>
@endsection
