<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
<a class="navbar-brand fw-bold text-primary fs-4 d-flex align-items-center" href="/" style="gap: 0.75rem;">
    <!-- Responsive circular logo -->
    <img src="{{ websiteInfo() && websiteInfo()->logo_path ? asset('storage/' . ltrim(websiteInfo()->logo_path, '/')) : asset('images/default-logo.png') }}"
         alt="{{ websiteInfo() ? websiteInfo()->website_name : 'Website Logo' }}"
         style="
            width: clamp(1.5rem, 4vw, 3.5rem);
            height: clamp(1.5rem, 4vw, 3.5rem);
            border-radius: 50%;
            object-fit: cover;
            display: inline-block;
            vertical-align: middle;
         ">
    <span style="font-size: clamp(1rem, 2vw, 1.5rem);">
        {{ websiteInfo() ? websiteInfo()->website_name : 'Website Name' }}
    </span>
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('booking.create') }}">Book Repair</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('status') }}">Check Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
