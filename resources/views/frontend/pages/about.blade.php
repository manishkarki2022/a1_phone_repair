@extends('frontend.layout.app')

@section('title', 'About Us - ' . websiteInfo()->website_name . ' | Device Repair Specialists')

@section('content')



<!-- About Page -->
<div id="about" class="page" itemscope itemtype="https://schema.org/AboutPage">
    <div class="container">
        <h1 class="section-title" itemprop="headline">About <span itemprop="name">{{ websiteInfo()->website_name }}</span></h1>

        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <p style="font-size: 1.2rem; margin-bottom: 2rem;" itemprop="description">
                At {{ websiteInfo()->website_name }}, we're passionate about bringing your electronic devices back to life.
                With over <span itemprop="foundingDate">10 years</span> of experience in the industry, our certified technicians have the
                expertise to handle any repair challenge.
            </p>

            <div style="background: white; padding: 3rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin: 2rem 0;"
                 itemprop="mainEntity" itemscope itemtype="https://schema.org/Organization">
                <h2 itemprop="slogan">Our Mission</h2>
                <p itemprop="description">To provide fast, reliable, and affordable device repair services while maintaining the highest standards of quality and customer satisfaction.</p>
            </div>

            <div style="background: white; padding: 3rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin: 2rem 0;">
                <h2>Why Choose Us?</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 2rem;">
                    <div itemscope itemtype="https://schema.org/Service">
                        <i class="fas fa-certificate" style="font-size: 2rem; color: #2563eb; margin-bottom: 1rem;"></i>
                        <h3 itemprop="name">Certified Technicians</h3>
                        <p itemprop="description">All our technicians are certified and regularly trained on the latest repair techniques.</p>
                        <meta itemprop="serviceType" content="Device Repair">
                    </div>
                    <div itemscope itemtype="https://schema.org/Service">
                        <i class="fas fa-tools" style="font-size: 2rem; color: #2563eb; margin-bottom: 1rem;"></i>
                        <h3 itemprop="name">Quality Parts</h3>
                        <p itemprop="description">We use only high-quality, genuine parts for all repairs to ensure longevity.</p>
                        <meta itemprop="serviceType" content="Device Repair">
                    </div>
                    <div itemscope itemtype="https://schema.org/Service">
                        <i class="fas fa-handshake" style="font-size: 2rem; color: #2563eb; margin-bottom: 1rem;"></i>
                        <h3 itemprop="name">Customer First</h3>
                        <p itemprop="description">Your satisfaction is our priority. We stand behind every repair we perform.</p>
                        <meta itemprop="serviceType" content="Device Repair">
                    </div>
                </div>
            </div>

            <div style="background: #2563eb; color: white; padding: 2rem; border-radius: 15px;"
                 itemscope itemtype="https://schema.org/WarrantyPromise">
                <h2 itemprop="name">Service Guarantee</h2>
                <p itemprop="description">All repairs come with our comprehensive <span itemprop="warrantyScope">30-day warranty</span>. If you experience any issues with our repair within 30 days, we'll fix it at no additional cost.</p>
            </div>
        </div>

        <!-- Team Section - Add if you have team members -->
        <div style="margin-top: 4rem; text-align: center;">
            <h2>Meet Our Team</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
                <div itemscope itemtype="https://schema.org/Person">
                    <h3 itemprop="name">Rajesh Karki</h3>
                    <p itemprop="jobTitle">Lead Technician</p>
                    <p itemprop="description">15+ years of experience in smartphone and laptop repairs</p>
                </div>
                <!-- Add more team members as needed -->
            </div>
        </div>
    </div>
</div>
@endsection
