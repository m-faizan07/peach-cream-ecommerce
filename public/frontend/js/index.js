// Function to load components
async function loadComponent(elementId, filePath) {
    try {
        const response = await fetch(filePath);
        if (response.ok) {
            const content = await response.text();
            document.getElementById(elementId).innerHTML = content;
            return true;
        } else {
            console.error(`Failed to load component from ${filePath}: ${response.statusText}`);
            return false;
        }
    } catch (error) {
        console.error(`Error loading component: ${error}`);
        return false;
    }
}

// Carousel functionality for Trust Section
let currentTrustSlide = 0;
const trustTestimonials = [
    {
        image: "images/doc.jpg",
        quote: "Perianal skin is uniquely vulnerable, and for years the only options were harsh medicated creams. Peach Cream offers a gentle, barrier-supporting alternative that patients can use daily—a true step forward in intimate skincare.",
        name: "Dr. Sarah Johnson",
        title: "OB/GYN & advisor"
    },
    {
        image: "images/doc.jpg",
        quote: "As a dermatologist, I've seen countless patients struggle with sensitive skin issues. Peach Cream's formulation is exactly what the market needed - gentle, effective, and designed for daily use without harsh chemicals.",
        name: "Dr. Michael Chen",
        title: "Dermatologist & consultant"
    },
    {
        image: "images/doc.jpg",
        quote: "The ceramide complex in Peach Cream is scientifically backed and clinically proven. It's refreshing to see a product that prioritizes skin barrier health over quick fixes. I recommend it to my patients regularly.",
        name: "Dr. Emily Rodriguez",
        title: "Clinical researcher"
    }
];

function updateTrustCarousel() {
    const testimonial = trustTestimonials[currentTrustSlide];
    const testimonialCard = document.querySelector('.testimonial-card');
    
    if (testimonialCard) {
        // Add fade effect
        testimonialCard.style.opacity = '0';
        testimonialCard.style.transition = 'opacity 0.3s ease';
        
        setTimeout(() => {
            testimonialCard.innerHTML = `
                <div class="testimonial-header">
                    <img src="${testimonial.image}" alt="${testimonial.name}" class="doctor-img">
                    <p class="quote-text">"${testimonial.quote}"</p>
                </div>
                <div class="testimonial-footer">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="doctor-name">${testimonial.name}, <span>${testimonial.title}</span></div>
                </div>
            `;
            testimonialCard.style.opacity = '1';
        }, 300);
    }
    
    // Update dots
    const trustDots = document.querySelectorAll('.trust-section .carousel-dots .dot');
    trustDots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentTrustSlide);
    });
}

// Carousel functionality for Stories Section
let currentStoriesSlide = 0;

function updateStoriesCarousel() {
    // Update dots
    const storiesDots = document.querySelectorAll('.stories-section .carousel-dots .dot');
    
    storiesDots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentStoriesSlide);
    });
}

// Initialize all functionality
async function initializeApp() {
    // Load components first
    const headerLoaded = await loadComponent('header-placeholder', 'components/header.html');
    const footerLoaded = await loadComponent('footer-placeholder', 'components/footer.html');

    // Initialize carousels
    // Trust section carousel dots click
    const trustDots = document.querySelectorAll('.trust-section .carousel-dots .dot');
    trustDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentTrustSlide = index;
            updateTrustCarousel();
        });
    });
    
    // Stories section carousel dots click
    const storiesDots = document.querySelectorAll('.stories-section .carousel-dots .dot');
    storiesDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentStoriesSlide = index;
            updateStoriesCarousel();
        });
    });
    
    // Auto-rotate trust carousel every 5 seconds
    setInterval(() => {
        currentTrustSlide = (currentTrustSlide + 1) % trustTestimonials.length;
        updateTrustCarousel();
    }, 5000);
    
    // Initialize carousels
    updateTrustCarousel();
    updateStoriesCarousel();

    // Smooth scroll for anchor links (re-run to catch links in header/footer)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Newsletter form submission (now in footer)
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            alert(`Thank you for subscribing with: ${email}`);
            this.reset();
        });
    }

    // Highlight active nav link
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (currentPath.endsWith(href) || (currentPath === '/' && href === 'index.html')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });

    // Handle mobile menu toggle
    const mobileMenuOpen = document.getElementById('mobile-menu-open');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-nav-links a');

    if (mobileMenuOpen && mobileMenu) {
        mobileMenuOpen.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (mobileMenuClose && mobileMenu) {
        mobileMenuClose.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mobileMenu) {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Close mobile menu on window resize if switching to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 992 && mobileMenu && mobileMenu.classList.contains('active')) {
            mobileMenu.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Scroll to Top functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (scrollToTopBtn) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Run app
document.addEventListener('DOMContentLoaded', initializeApp);

document.addEventListener('DOMContentLoaded', function() {
    const smsConsent = document.getElementById('sms-consent');
    const disclosureSection = document.getElementById('sms-disclosure-section');

    if (smsConsent && disclosureSection) {
        smsConsent.addEventListener('change', function() {
            if (this.checked) {
                disclosureSection.classList.remove('hidden');
            } else {
                disclosureSection.classList.add('hidden');
            }
        });
    }

    // Payment Method Selection
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    const payBtn = document.getElementById('pay-now-btn');

    paymentOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Remove selected class from all
            document.querySelectorAll('.payment-method-option').forEach(opt => opt.classList.remove('selected'));
            
            // Add to parent
            if (this.checked) {
                this.closest('.payment-method-option').classList.add('selected');
                
                // Update Button
                if (this.value === 'paypal' && payBtn) {
                    payBtn.textContent = 'Pay with PayPal';
                    payBtn.classList.add('paypal-btn');
                    
                    // Show billing form when PayPal is selected as requested
                    const billingDifferent = document.getElementById('billing-different');
                    const billingForm = document.getElementById('billing-address-form');
                    if (billingDifferent && billingForm) {
                        billingDifferent.checked = true;
                        billingForm.classList.remove('hidden');
                        document.querySelectorAll('.billing-option').forEach(opt => opt.classList.remove('selected'));
                        billingDifferent.closest('.billing-option').classList.add('selected');
                    }
                } else if (payBtn) {
                    payBtn.textContent = 'Pay Now';
                    payBtn.classList.remove('paypal-btn');
                }
            }
        });
    });

    // Billing Address Selection
    const billingOptions = document.querySelectorAll('input[name="billing_address"]');
    const billingForm = document.getElementById('billing-address-form');

    billingOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Remove selected class from all
            document.querySelectorAll('.billing-option').forEach(opt => opt.classList.remove('selected'));

            if (this.checked) {
                this.closest('.billing-option').classList.add('selected');
                
                // Show/Hide Form
                if (this.value === 'different' && billingForm) {
                    billingForm.classList.remove('hidden');
                } else if (billingForm) {
                    billingForm.classList.add('hidden');
                }
            }
        });
    });
});
