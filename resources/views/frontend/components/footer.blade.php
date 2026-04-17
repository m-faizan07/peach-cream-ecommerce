<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="newsletter-bar">
        <div class="newsletter-text">
            <h3>Sign Up & Subscribe To Our Newsletter</h3>
            <p>Subscribe to our latest newsletter to get news about special discounts & upcoming sales.</p>
        </div>
        <form class="newsletter-form" method="POST" action="{{ route('frontend.newsletter.subscribe') }}">
            @csrf
            <input type="email" name="email" placeholder="Your email address" required>
            <button type="submit" class="subscribe-btn">Subscribe</button>
        </form>
    </div>
</section>

<!-- Footer Section -->
<footer class="footer">
    <div class="footer-top">
        <a href="{{ route('frontend.home') }}" class="footer-logo">
            <img src="{{ asset('frontend/images/peachlogo.png') }}" alt="Peach Cream Logo">

        </a>
        <p>Every area of your skin, including your peach, deserves consistent and thoughtful care. Take a more
            complete approach to skin health.</p>
    </div>

    <div class="footer-grid">
        <!-- Disclaimer Col -->
        <div class="footer-col">
            <h4>Important Disclaimer</h4>
            <p>These statements have not been evaluated by the U.S. Food and Drug Administration. This product is
                not intended to diagnose, treat, cure, or prevent any disease.</p>
            <br>
            <p>Results may vary based on individual health, lifestyle, and diet. Testimonials reflect personal
                experiences and are not guaranteed for everyone.</p>
        </div>

        <!-- Links Col -->
        <div class="footer-col">
            <h4>Information</h4>
            <ul class="footer-links">
                <li><a href="#">Track Your Order</a></li>
                <li><a href="#">Returns & Exchanges</a></li>
                <li><a href="#">Shipping Information</a></li>
                <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
                <li><a href="{{ route('frontend.about') }}">About Us</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>

        <!-- Contact Col -->
        <div class="footer-col">
            <h4>Contact Us</h4>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <span>1 847-737-7622</span>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-fax"></i>
                    <span>1 847-737-7623</span>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <span>support@peachcream.com</span>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>9933 Franklin Ave Franklin Park IL 60131</span>
                </div>
            </div>

            <div class="footer-social">
                <h5>Follow us</h5>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="copyright">© 2026 All Rights Reserved</div>
        <div class="payment-icons">
            <img src="{{ asset('frontend/images/american express.png') }}" alt="">
            <img src="{{ asset('frontend/images/master.png') }}" alt="master">
            <img src="{{ asset('frontend/images/ebank.png') }}" alt="ebank">
            <img src="{{ asset('frontend/images/paypall.png') }}" alt="paypall">
            <img src="{{ asset('frontend/images/discover.png') }}" alt="discover">
            <img src="{{ asset('frontend/images/visa.png') }}" alt="visa">
            <img src="{{ asset('frontend/images/wiretransfer.png') }}" alt="wiretansfer">
        </div>

    </div>
</footer>

<!-- Scroll To Top Button -->
<button id="scrollToTop" class="scroll-to-top" title="Go to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>