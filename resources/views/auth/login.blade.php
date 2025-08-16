<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $site = websiteInfo()->first();
        $siteName = $site->website_name ?? 'Your App';
        $logoPath = $site->logo_path ?? null;
        $logoUrl = $logoPath ? asset('storage/' . $logoPath) : asset('default/website.png');
    @endphp

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteName }} - @yield('title', 'Login')</title>
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <style>
        .login-page {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-box {
            width: 400px;
            max-width: 90%;
        }
        .login-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: none;
            overflow: hidden;
        }
        .login-card-header {
            background: transparent;
            border-bottom: none;
            padding: 1.5rem;
        }
        .login-card-body {
            padding: 2rem;
        }
        .login-logo img {
            border: 3px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        .form-control {
            border-left: none;
            height: 45px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #3b5cb8;
            border-color: #3b5cb8;
        }
        .login-box-msg {
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: #6c757d;
        }
        .social-auth-links a {
            color: #6c757d;
            text-decoration: none;
        }
        .social-auth-links a:hover {
            color: #4e73df;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Login Logo -->
        <div class="login-logo text-center mb-4">
            <a href="{{ url('/') }}">
                <img src="{{ $logoUrl }}"
                     alt="{{ $siteName }}"
                     class="img-fluid rounded-circle"
                     style="width: 100px; height: 100px; object-fit: cover;">
            </a>
            <h4 class="mt-3 text-white">{{ $siteName }}</h4>
        </div>

        <!-- Login Card -->
        <div class="card login-card">
            <div class="card-body login-card-body">
                <p class="login-box-msg text-center">Sign in to your account</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Email address"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
                                   placeholder="Password"
                                   required
                                   autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="text-muted">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-primary">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add loading state to form submission
            $('form').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing in...');
            });

            // Focus first input field
            $('form').find('input:visible:first').focus();
        });
    </script>
</body>
</html>
