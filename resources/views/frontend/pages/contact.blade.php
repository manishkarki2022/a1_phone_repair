@extends('frontend.layout.app')

@section('title', 'Contact Us - ' . websiteInfo()->website_name)

@section('content')



<!-- Contact Page -->
<div id="contact" class="page" itemscope itemtype="https://schema.org/ContactPage">
    <div class="container">
        <h1 class="section-title" itemprop="headline">Contact Us</h1>

        {{-- Success message --}}
        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contact-grid">
            <div itemprop="mainContentOfPage">
                <h2>Send us a message</h2>
                <form action="{{ route('contact.submit') }}" method="POST" itemscope itemtype="https://schema.org/ContactForm">
                    @csrf

                    <div class="form-group">
                        <label for="inquiryType">Inquiry Type</label>
                        <select id="inquiryType" name="inquiry_type" required>
                            <option value="">Select inquiry type</option>
                            @foreach(App\Models\ContactSubmission::$inquiryTypes as $key => $type)
                                <option value="{{ $key }}" {{ old('inquiry_type') == $key ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('inquiry_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contactName">Name *</label>
                        <input type="text" id="contactName" name="name" value="{{ old('name') }}" required itemprop="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contactEmail">Email *</label>
                        <input type="email" id="contactEmail" name="email" value="{{ old('email') }}" required itemprop="email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contactPhone">Phone</label>
                        <input type="tel" id="contactPhone" name="phone" value="{{ old('phone') }}" itemprop="telephone">
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" itemprop="subjectOf">
                        @error('subject')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" required itemprop="text">{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" itemprop="potentialAction">Send Message</button>
                </form>
            </div>

            <div class="contact-info" itemscope itemtype="https://schema.org/LocalBusiness">
                <h2>Get in Touch</h2>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                        <strong>Address</strong><br>
                        <span itemprop="streetAddress">{{ websiteInfo()->address }}</span><br>
                        <span itemprop="addressLocality">{{ websiteInfo()->city }}</span>,
                        <span itemprop="addressRegion">{{ websiteInfo()->state }}</span>
                        <span itemprop="postalCode">{{ websiteInfo()->zip }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Phone</strong><br>
                        <a href="tel:{{ websiteInfo()->phone }}" itemprop="telephone">{{ websiteInfo()->phone }}</a>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong><br>
                        <a href="mailto:{{ websiteInfo()->email }}" itemprop="email">{{ websiteInfo()->email }}</a>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <div itemprop="openingHoursSpecification" itemscope itemtype="https://schema.org/OpeningHoursSpecification">
                        <strong>Business Hours</strong><br>
                        <meta itemprop="dayOfWeek" content="Mo,Tu,We,Th,Fr">Mon-Fri: <span itemprop="opens">09:00</span> AM - <span itemprop="closes">18:00</span> PM<br>
                        <meta itemprop="dayOfWeek" content="Sa">Sat: 10 AM - 4 PM<br>
                        Sun: Closed
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section with FAQPage schema -->
        <div style="margin-top: 4rem;" itemscope itemtype="https://schema.org/FAQPage">
            <h2>Frequently Asked Questions</h2>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="faq-question" onclick="toggleFAQ(this)" itemprop="name">
                    <span>How long do repairs typically take?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Most repairs are completed within 1-3 business days. Complex repairs may take up to a week. We'll provide an estimated timeline when you drop off your device.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="faq-question" onclick="toggleFAQ(this)" itemprop="name">
                    <span>Do you offer warranty on repairs?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>Yes! All repairs come with a 30-day warranty covering the specific repair performed. If the same issue occurs within 30 days, we'll fix it at no additional cost.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div class="faq-question" onclick="toggleFAQ(this)" itemprop="name">
                    <span>What if my device can't be repaired?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div itemprop="text">
                        <p>If we determine your device cannot be repaired economically, there's no charge for the diagnostic. We'll explain why the repair isn't feasible and suggest alternatives.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* FAQ toggle animation */
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .faq-item.active .faq-answer {
        max-height: 500px;
        transition: max-height 0.5s ease-in;
    }
    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleFAQ(element) {
        const faqItem = element.parentElement;
        faqItem.classList.toggle('active');
    }
</script>
@endpush
