@extends('frontend.layout.app')

@section('title', $seoTitle ?? 'Professional Device Repair Services | ' . websiteInfo()->website_name)

@section('content')
<!-- Hero Section with structured data -->
<section class="hero" itemscope itemtype="https://schema.org/WebPageElement">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @forelse($heroSliders as $slider)
            <div class="swiper-slide hero-slide" itemprop="hasPart" itemscope itemtype="https://schema.org/ImageObject">
                @if($slider->image_url)
                <img class="hero-img"
                     src="{{ $slider->image_url }}"
                     alt="{{ $slider->title }}"
                     loading="lazy"
                     itemprop="contentUrl">
                @endif
                <div class="slide-content">
                    <h1 itemprop="name">{{ $slider->title }}</h1>
                    @if($slider->content)
                    <div class="slide-description" itemprop="description">
                        {!! nl2br(e($slider->content)) !!}
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="swiper-slide hero-slide">
                <div class="slide-content">
                    <h1>Welcome to {{ websiteInfo()->website_name }}</h1>
                    <div class="slide-description">
                        Professional repair services for all your devices
                    </div>
                    <a href="#services" class="cta-button">View Services</a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Discount Banners with microdata -->
<section class="discount-banners" itemscope itemtype="https://schema.org/ItemList">
    <div class="banner-container">
        <div class="discount-banner" itemprop="itemListElement" itemscope itemtype="https://schema.org/Offer">
            <h4 itemprop="name"><i class="fas fa-gift"></i> Free Diagnostic!</h4>
            <p itemprop="description">Get your device diagnosed at no cost</p>
        </div>
        <div class="discount-banner" itemprop="itemListElement" itemscope itemtype="https://schema.org/Offer">
            <h4 itemprop="name"><i class="fas fa-clock"></i> Same Day Service</h4>
            <p itemprop="description">Most repairs completed within hours</p>
        </div>
        <div class="discount-banner" itemprop="itemListElement" itemscope itemtype="https://schema.org/Offer">
            <h4 itemprop="name"><i class="fas fa-shield-alt"></i> 30-Day Warranty</h4>
            <p itemprop="description">All repairs backed by our guarantee</p>
        </div>
    </div>
</section>

<!-- Device Categories with semantic markup -->
<section class="device-categories">
    <div class="container">
        <h2 class="section-title">Our Repair Services</h2>
        <div class="categories-grid" role="list">
            @foreach([
                [
                    'name' => 'Smartphones',
                    'description' => 'iPhone, Samsung Galaxy, Google Pixel, OnePlus and more',
                    'image' => 'https://img.freepik.com/free-photo/repairman-uses-magnifier-tweezers-repair-damaged-smartphone-close-up-photo-disassembled-smartphone_613910-20862.jpg',
                    'icon' => 'fas fa-mobile-alt'
                ],
                [
                    'name' => 'Smartwatches',
                    'description' => 'Apple Watch, Samsung Galaxy Watch, Fitbit repairs',
                    'image' => 'https://xgcellphonerepair.io/wp-content/uploads/2023/07/Expert-Smartwatch-Repair.jpg',
                    'icon' => 'fas fa-clock'
                ],
                [
                    'name' => 'Laptops',
                    'description' => 'MacBook, Dell, HP, Lenovo, ASUS repairs',
                    'image' => 'https://plus.unsplash.com/premium_photo-1664301887532-328f07bb2c24?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bGFwdG9wJTIwcmVwYWlyfGVufDB8fDB8fHww',
                    'icon' => 'fas fa-laptop'
                ],
                [
                    'name' => 'Gaming Consoles',
                    'description' => 'PlayStation, Xbox, Nintendo Switch repairs',
                    'image' => 'https://techandgames.co.uk/wp-content/uploads/2025/05/hero-gaming-console-repair.webp',
                    'icon' => 'fas fa-gamepad'
                ],
                [
                    'name' => 'Tablets',
                    'description' => 'iPad, Samsung Tab, Surface Pro repairs',
                    'image' => 'https://indianrenters.com/wp-content/uploads/Mixed-Tabs-on-rent.jpg',
                    'icon' => 'fas fa-tablet-alt'
                ],
                [
                    'name' => 'Other Electronics',
                    'description' => 'Headphones, speakers, and other devices',
                    'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80',
                    'icon' => 'fas fa-cog'
                ]
            ] as $category)
            <div class="category-card" role="listitem" onclick="showPage('booking')"
                 itemscope itemtype="https://schema.org/Service">
                <div class="category-image" style="background-image: url('{{ $category['image'] }}')">
                    <div class="category-icon">
                        <i class="{{ $category['icon'] }}"></i>
                    </div>
                </div>
                <h3 itemprop="name">{{ $category['name'] }}</h3>
                <p itemprop="description">{{ $category['description'] }}</p>
                <meta itemprop="serviceType" content="{{ $category['name'] }} Repair">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us with organization schema -->
<section class="why-choose-us" itemscope itemtype="https://schema.org/Organization">
    <div class="container">
        <h2 class="section-title" style="color: white;">Why Choose <span itemprop="name">{{ websiteInfo()->website_name }}</span>?</h2>
        <div class="features-grid">
            <div class="feature" itemprop="makesOffer" itemscope itemtype="https://schema.org/Offer">
                <div class="feature-icon">
                    <i class="fas fa-user-cog"></i>
                </div>
                <h3 itemprop="name">Professional Technicians</h3>
                <p itemprop="description">Certified experts with years of experience</p>
            </div>
            <div class="feature" itemprop="makesOffer" itemscope itemtype="https://schema.org/Offer">
                <div class="feature-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h3 itemprop="name">Quality Guarantee</h3>
                <p itemprop="description">100% satisfaction guaranteed on all repairs</p>
            </div>
            <div class="feature" itemprop="makesOffer" itemscope itemtype="https://schema.org/Offer">
                <div class="feature-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <h3 itemprop="name">Fast Turnaround</h3>
                <p itemprop="description">Quick repairs without compromising quality</p>
            </div>
            <div class="feature" itemprop="makesOffer" itemscope itemtype="https://schema.org/Offer">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 itemprop="name">Warranty Included</h3>
                <p itemprop="description">All repairs come with comprehensive warranty</p>
            </div>
        </div>
    </div>
</section>

<!-- Before & After Section with comparison schema -->
<section style="background-color: #f8fafc; padding: 1rem 1rem;" itemscope itemtype="https://schema.org/Product">
    <div style="max-width: 1200px; margin: 0 auto;">
       <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 3rem;">
            <div>
                <h2 style="font-size: 2.25rem; font-weight: 700; color: #111827; margin-bottom: 1rem;">Before & After Repair</h2>
                <p style="font-size: 1.125rem; color: #4b5563; margin-bottom: 2rem; line-height: 1.6;">
                    Witness the transformation as our experts restore your device to perfection
                </p>

                <div class="beer-slider" data-beer-label="Before" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); height: 400px;">
                    <img src="{{ asset('images/1.png') }}" alt="Device before repair" itemprop="image" style="width: 100%; height: 100%; object-fit: cover;">
                    <div class="beer-reveal" data-beer-label="After">
                        <img src="{{ asset('images/3.png') }}" alt="Device after repair" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); height: 400px;">
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); border-left: 4px solid #2563eb;">
                <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin-bottom: 1.5rem; position: relative; padding-left: 1rem;">
                    <span style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: linear-gradient(to bottom, #2563eb, #1e40af); border-radius: 2px;"></span>
                    Excellence in Every Repair
                </h2>

                <p style="font-size: 1.05rem; color: #4b5563; line-height: 1.7; margin-bottom: 1.5rem;">
                    At <strong style="color: #111827;" itemprop="name">{{ websiteInfo()->website_name }}</strong>, we combine technical expertise with premium components to deliver repairs that exceed expectations.
                </p>

                <ul style="list-style: none; padding-left: 0; margin: 2rem 0;">
                    <li style="margin-bottom: 0.75rem; padding-left: 2rem; position: relative; color: #374151; line-height: 1.6;">
                        <span style="position: absolute; left: 0; top: 0.25rem; width: 24px; height: 24px; background-color: rgba(37, 99, 235, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: #2563eb;">
                                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        Genuine manufacturer-approved parts
                    </li>
                    <!-- Other list items -->
                </ul>

                <a href="#contact" style="display: inline-block; background-color: #2563eb; color: white; padding: 0.875rem 1.75rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.2s ease;">
                    Book Your Repair Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Map Section with LocalBusiness schema -->
<section class="map-section" style="background-color: #f1f5f9; padding: 3rem 1rem;" itemscope itemtype="https://schema.org/LocalBusiness">
    <div class="container" style="max-width: 1200px; margin: auto;">
        <h2 class="section-title" style="text-align: center; font-size: 2rem; margin-bottom: 2rem;">Our Location</h2>
        <div id="map" style="width: 100%; height: 400px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></div>
        <div style="margin-top: 1.5rem; text-align: center;">
            <p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <span itemprop="streetAddress">{{ websiteInfo()->address ?? '123 Main St' }}</span>,
                <span itemprop="addressLocality">{{ websiteInfo()->city ?? 'City' }}</span>,
                <span itemprop="addressRegion">{{ websiteInfo()->state ?? 'State' }}</span>
                <span itemprop="postalCode">{{ websiteInfo()->zip ?? '12345' }}</span>
            </p>
            <p>Phone: <span itemprop="telephone">{{ websiteInfo()->phone ?? '+1-XXX-XXX-XXXX' }}</span></p>
            <p>Hours: Mon-Sat 9:00 AM - 6:00 PM</p>
        </div>
    </div>
</section>

<!-- Brand Logo Slider -->
<section class="brand-slider-section">
    <h2 class="section-title">Our Trusted Partners</h2>
    <div class="swiper brand-swiper" style="padding: 1.5rem;">
        <div class="swiper-wrapper">
            @foreach(['apple', 'samsung', 'sony', 'hp', 'acer', 'google'] as $brand)
            <div class="swiper-slide">
                <img src="{{ asset("sliderimg/$brand.svg") }}" alt="{{ ucfirst($brand) }} repairs" class="brand-logo" loading="lazy">
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
