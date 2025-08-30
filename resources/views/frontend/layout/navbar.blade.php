<style>
/* Navbar wrapper */
.custom-nav {
    position: sticky;
    top: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    padding: 0.5rem 1rem;
    z-index: 1000;
    transition: all 0.3s ease;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

/* Container */
.custom-container {
    width: 100%;
    max-width: 1140px;
    margin: 0 auto;
    display: flex;
    align-items: center; /* vertical align center */
    justify-content: space-between;
}

/* Brand */
.custom-brand {
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #2563eb;
    text-decoration: none;
    gap: 0.75rem;
    font-size: 1.25rem;
}
.custom-brand img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Menu */
.custom-menu {
    display: flex;
    align-items: center;
    list-style: none;
    gap: 0.5rem;
}
.custom-menu li {
    display: inline-block;
    padding-top: 0.25rem;
}
.custom-menu a {
    text-decoration: none;
    color: #1e293b;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.custom-menu a:hover,
.custom-menu a.active {
    color: #2563eb;
    background: rgba(37, 99, 235, 0.08);
}

/* Button */
.custom-btn {
    background: #2563eb;
    color: #f8fafc !important;
    padding: 0.375rem 1rem;
    border-radius: 50px;
    font-weight: 500;
    transition: all 0.3s ease;
    margin-left: 0.5rem;
}
.custom-btn:hover {
    background: #0f2153;
}

/* Hamburger */
.custom-hamburger {
    display: none; /* Hide on large screens */
    flex-direction: column;
    cursor: pointer;
    gap: 5px;
}
.custom-hamburger span {
    width: 25px;
    height: 2px;
    background: #1e293b;
    border-radius: 2px;
    transition: all 0.3s ease;
}
.custom-hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}
.custom-hamburger.active span:nth-child(2) {
    opacity: 0;
}
.custom-hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* Responsive */
@media (max-width: 991px) {
    .custom-menu {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        flex-direction: column;
        background: #f8fafc;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
    }
    .custom-menu.open {
        max-height: 600px;
        padding: 0.5rem 0;
    }
    .custom-menu li {
        width: 100%;
        margin: 0.25rem 0; /* vertical gap */
    }
    .custom-menu a {
        width: 100%;
        padding: 0.85rem 1.25rem;
        display: block;
    }
    .custom-menu .custom-btn {
        width: 90%;           /* almost full width */
        text-align: center;   /* center text */
        margin: 0.5rem auto;  /* auto margin to center */
        display: block;
        padding: 0.75rem 0;   /* larger touch area */
        font-size: 1rem;
    }
    .custom-hamburger {
        display: flex; /* show hamburger only on mobile */
    }
}
</style>

<nav class="custom-nav">
    <div class="custom-container">
        <!-- Brand -->
        <a class="custom-brand" href="{{ route('home') }}">
            <img src="{{ websiteInfo() && websiteInfo()->logo_path ? asset('storage/' . ltrim(websiteInfo()->logo_path, '/')) : asset('images/default-logo.png') }}" alt="Logo">
            <span>{{ websiteInfo()->website_name ?? 'Website' }}</span>
        </a>

        <!-- Hamburger -->
        <div class="custom-hamburger" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Menu -->
        <ul class="custom-menu" id="customMenu">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('booking.create') }}" class="{{ request()->routeIs('booking.create') ? 'active' : '' }}">Book Repair</a></li>
            <li><a href="{{ route('status') }}" class="{{ request()->routeIs('status') || request()->routeIs('check-status') ? 'active' : '' }}">Check Status</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') || request()->routeIs('contact.submit') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('booking.create') }}" class="custom-btn">Book Now</a></li>
        </ul>
    </div>
</nav>

<script>
const menuToggle = document.getElementById("menuToggle");
const customMenu = document.getElementById("customMenu");

menuToggle.addEventListener("click", e => {
    e.stopPropagation();
    customMenu.classList.toggle("open");
    menuToggle.classList.toggle("active");
});

// Close when clicking outside
document.addEventListener("click", e => {
    if (!customMenu.contains(e.target) && !menuToggle.contains(e.target)) {
        customMenu.classList.remove("open");
        menuToggle.classList.remove("active");
    }
});

// Close menu when clicking a link
document.querySelectorAll('.custom-menu a').forEach(link => {
    link.addEventListener('click', () => {
        customMenu.classList.remove("open");
        menuToggle.classList.remove("active");
    });
});
</script>
