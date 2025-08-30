<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ websiteInfo()->website_name }} - @yield('title', '404-error')</title>
    {{-- Dynamic SEO Meta Tags --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f8fafc, #e2e8f0);
      color: #1f2937;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .error-icon {
      font-size: 4rem;
      color: #6b7280;
      animation: bounce 1.5s infinite;
    }

    .custom-btn {
      transition: all 0.3s ease-in-out;
    }

    .custom-btn:hover {
      background-color: #f3e8ff !important;
      transform: scale(1.05);
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
  </style>
</head>
<body>
  <div class="text-center px-3">
    <div class="error-icon mb-3"><i class="fas fa-triangle-exclamation"></i></div>
    <h1 class="display-1 fw-bold">404</h1>
    <p class="fs-3 fw-semibold mt-3">Oops! Page Not Found</p>
    <p class="text-muted mb-4">The page you're looking for doesn’t exist or may have been moved.</p>

    <div class="d-flex flex-wrap justify-content-center gap-3">
      <a href="/" class="btn btn-primary fw-semibold rounded-pill px-4 py-2 custom-btn">
        <i class="fas fa-home me-2"></i> Go Home
      </a>
      <button onclick="history.back()" class="btn btn-outline-secondary fw-semibold rounded-pill px-4 py-2 custom-btn">
        <i class="fas fa-arrow-left me-2"></i> Go Back
      </button>
    </div>
  </div>
</body>
</html>
