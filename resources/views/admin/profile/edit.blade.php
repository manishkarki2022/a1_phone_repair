@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Message -->
                @if (session('status') === 'profile-updated')
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="icon fas fa-check"></i> Profile updated successfully!
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <!-- Profile Update Card -->
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Profile Information</h3>
                            </div>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Full Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                </div>
                                                @error('name')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email Address</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    </div>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                </div>
                                                @error('email')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5><i class="fas fa-key mr-2"></i>Change Password</h5>
                                            <p class="text-muted small mb-3">
                                                Leave blank if you don't want to change your password.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="current_password">Current Password</label>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                       id="current_password" name="current_password">
                                                @error('current_password')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                       id="password" name="password">
                                                @error('password')
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input type="password" class="form-control"
                                                       id="password_confirmation" name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <small class="form-text text-muted">
                                                Password must be at least 8 characters and include uppercase, lowercase, number, and special character.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i> Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    // Form submission loading state
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing...');
    });
});
</script>
<style>
    .card {
        margin-bottom: 1.5rem;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: 0.75rem 1.25rem;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .input-group-text {
        min-width: 40px;
        justify-content: center;
    }
</style>

@endsection
