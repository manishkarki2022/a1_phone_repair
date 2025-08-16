<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ websiteInfo()->website_name }} - @yield('title', 'Default Title')</title>
      {{-- Dynamic SEO Meta Tags --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="128*128" href="{{ websiteInfo() && websiteInfo()->first() && websiteInfo()->logo_path ? asset('/storage/' . websiteInfo()->first()->logo_path) : asset('default/website-16x16.png') }}">
    <meta name="description" content="Professional device repair services for smartphones, laptops, tablets, and more. Quick, reliable repairs with warranty included.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('custom/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/beerslider/dist/BeerSlider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Slider.js CSS -->
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">



</head>
<body style="min-height: 100vh; display: flex; flex-direction: column;">

 @include('frontend.layout.utilitybar')
@include('frontend.layout.navbar')
<!-- Header -->

<!-- Main Content -->
  <main style="flex: 1;">
        @yield('content')
    </main>



<!-- Footer -->
@include('frontend.layout.footer')




@yield('js')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Beer Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/beerslider/dist/BeerSlider.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script src="{{ asset('custom/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([40.05994279063317, -82.95158503800907], 13); // Kathmandu or your business location

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([40.05994279063317, -82.95158503800907])
            .addTo(map)
            .bindPopup("We are here - A1 Phone Repair")
            .openPopup();
    });
</script>
</body>
</html>
