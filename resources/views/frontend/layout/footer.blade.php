<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>{{ websiteInfo()->website_name }}</h3>
                <p>{{ websiteInfo()->slogan }}</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="/" >Home</a></li>
                    <li><a href="{{ route('booking.create') }}">Book Repair</a></li>
                    <li><a href="{{ route('status') }}" >Check Status</a></li>
                    <li><a href="{{ route('contact') }}" >Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> {{ websiteInfo()->address ?? '123 Main Street' }}, {{ websiteInfo()->city }}, {{ websiteInfo()->country }} {{ websiteInfo()->postal }}</p>
                <p><i class="fas fa-phone"></i> {{ websiteInfo()->phone }}</p>
                <p><i class="fas fa-envelope"></i> {{ websiteInfo()->email }}</p>
            </div>
            <div class="footer-section">
                <h3>Business Hours</h3>
                <p>Mon - Fri: 9 AM - 6 PM</p>
                <p>Saturday: 10 AM - 4 PM</p>
                <p>Sunday: Closed</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 {{ websiteInfo()->website_name }}. All rights reserved.</p>
        </div>
    </div>
</footer>
