<!-- Top Bar -->
<header class="top-bar">
    <div class="top-bar-left">
        <a href="tel:+15551234567"><i class="fa-solid fa-phone"></i> +1-555-123-4567</a>
        <a href="mailto:sales@packworks.com"><i class="fa-solid fa-envelope"></i> sales@packworks.com</a>
    </div>
    <div class="top-bar-center">
        Free Shipping on Orders $50+
    </div>
    <div class="top-bar-right">
        <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>
</header>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="{{ route('frontend.home') }}" class="logo">
        <img src="{{ asset('frontend/images/peachlogo.png') }}" alt="Peach Cream Logo">
    </a>

    <div class="nav-links">
        <a href="{{ route('frontend.home') }}">Home</a>
        <a href="{{ route('frontend.product') }}">Peach Cream</a>
        <a href="{{ route('frontend.about') }}">About Us</a>
        <a href="{{ route('frontend.contact') }}">Contact Us</a>
    </div>

    <div class="nav-actions">
        <a href="{{ route('frontend.cart') }}" class="cart-btn">
            <i class="fa-solid fa-cart-shopping"></i>
            <span style="font-size:11px; margin-left:6px;">{{ count(session('cart', [])) }}</span>
        </a>
        <a href="{{ route('frontend.product') }}" class="cta-btn">Get Peach Cream</a>
        <button class="mobile-menu-btn" id="mobile-menu-open">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobile-menu">
    <div class="mobile-menu-content">
        <button class="mobile-menu-close" id="mobile-menu-close">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="mobile-menu-logo">
            <img src="{{ asset('frontend/images/peachlogo.png') }}" alt="Peach Cream Logo">
        </div>

        <nav class="mobile-nav-links">
            <a href="{{ route('frontend.home') }}">Home</a>
            <a href="{{ route('frontend.product') }}">Shop</a>
            <a href="{{ route('frontend.about') }}">About Us</a>
            <a href="{{ route('frontend.contact') }}">Contact</a>
        </nav>

        <div class="mobile-menu-footer">
            <a href="tel:+15551234567" class="mobile-contact-item">
                <i class="fa-solid fa-phone"></i>
                <span>+1-555-123-4567</span>
            </a>
            <a href="mailto:sales@packworks.com" class="mobile-contact-item">
                <i class="fa-solid fa-envelope"></i>
                <span>sales@packworks.com</span>
            </a>
        </div>
    </div>
</div>
