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

function showUiMessage(type, text, title = null) {
    if (window.Swal) {
        window.Swal.fire({
            icon: type,
            title: title || (type === 'success' ? 'Success' : 'Error'),
            text,
            confirmButtonColor: '#111827'
        });
        return;
    }
    window.alert(text);
}

function updateStoriesCarousel() {
    // Update dots
    const storiesDots = document.querySelectorAll('.stories-section .carousel-dots .dot');
    
    storiesDots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentStoriesSlide);
    });
}

// Initialize all functionality
async function initializeApp() {
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

    // Keep newsletter as normal backend submit when action exists.

    // Product page Add To Cart button (keeps existing design, sends selected quantity).
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const qtyInput = document.getElementById('qtyInput');
    if (addToCartBtn && qtyInput && window.location.pathname === '/product') {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const qty = Math.max(parseInt(qtyInput.value || '1', 10), 1);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/add';
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = csrfToken;
            const quantity = document.createElement('input');
            quantity.type = 'hidden';
            quantity.name = 'quantity';
            quantity.value = String(qty);
            form.appendChild(token);
            form.appendChild(quantity);
            document.body.appendChild(form);
            form.submit();
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
    const isPaymentPage = window.location.pathname === '/payment';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    let stripe = null;
    let cardNumber = null;
    let cardExpiry = null;
    let cardCvc = null;

    if (isPaymentPage && window.Stripe && window.checkoutStripePublicKey) {
        stripe = window.Stripe(window.checkoutStripePublicKey);
        const elements = stripe.elements();
        const elementStyle = {
            base: {
                color: '#1f2937',
                fontSize: '18px',
                fontFamily: 'inherit'
            },
            invalid: {
                color: '#d32f2f'
            }
        };

        cardNumber = elements.create('cardNumber', { style: elementStyle });
        cardExpiry = elements.create('cardExpiry', { style: elementStyle });
        cardCvc = elements.create('cardCvc', { style: elementStyle });

        if (document.getElementById('stripe-card-number')) {
            cardNumber.mount('#stripe-card-number');
        }
        if (document.getElementById('stripe-card-expiry')) {
            cardExpiry.mount('#stripe-card-expiry');
        }
        if (document.getElementById('stripe-card-cvc')) {
            cardCvc.mount('#stripe-card-cvc');
        }
    }

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

    // Cart quantity controls -> backend session update without changing markup.
    window.updateCartQty = function(delta) {
        const qtyInput = document.querySelector('.cart-item .qty-input');
        if (!qtyInput) return;
        let qty = parseInt(qtyInput.value || '1', 10) + delta;
        if (qty < 1) qty = 1;
        qtyInput.value = String(qty);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/cart/update';

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const q = document.createElement('input');
        q.type = 'hidden';
        q.name = 'quantity';
        q.value = String(qty);

        form.appendChild(token);
        form.appendChild(q);
        document.body.appendChild(form);
        form.submit();
    };

    // Cart remove buttons clear cart.
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/clear';

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            form.appendChild(token);

            document.body.appendChild(form);
            form.submit();
        });
    });

    // Clear cart button in current static design.
    const clearCartLink = document.getElementById('clear-cart-link');
    if (clearCartLink) {
        clearCartLink.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/cart/clear';
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = csrfToken;
            form.appendChild(token);
            document.body.appendChild(form);
            form.submit();
        });
    }

    // Shipping information step: submit using POST, not query string.
    if (window.location.pathname === '/shipping') {
        const continueBtn = document.querySelector('a.continue-btn');
        if (continueBtn) {
            continueBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const email = document.querySelector('input[type="email"]')?.value?.trim() || '';
                const names = document.querySelectorAll('input[placeholder="First name"], input[placeholder="Last name"]');
                const firstName = names[0]?.value?.trim() || '';
                const lastName = names[1]?.value?.trim() || '';
                const address = document.querySelector('input[placeholder="Address"]')?.value?.trim() || '';
                const city = document.querySelector('input[placeholder="City"]')?.value?.trim() || '';
                const state = document.querySelector('.form-row.three-col select.form-input')?.value?.trim() || '';
                const zipcode = document.querySelector('input[placeholder="ZIP code"]')?.value?.trim() || '';
                const country = document.querySelector('.form-section select.form-input')?.value || 'United States';
                const mobile = document.querySelector('input[type="tel"]')?.value?.trim() || '';
                const newsletterOptIn = document.getElementById('email-me')?.checked ? 1 : 0;

                if (!email || !firstName || !lastName || !address || !city || !state || !zipcode || !mobile) {
                    showUiMessage('error', 'Please fill first name, last name, address, city, state, ZIP code, and mobile to continue.');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/shipping';
                const payload = {
                    _token: csrfToken,
                    email,
                    first_name: firstName,
                    last_name: lastName,
                    address,
                    city,
                    state,
                    zipcode,
                    mobile,
                    newsletter_opt_in: newsletterOptIn,
                    shipping_country: country,
                };
                Object.entries(payload).forEach(([k, v]) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = k;
                    input.value = String(v);
                    form.appendChild(input);
                });
                document.body.appendChild(form);
                form.submit();
            });
        }
    }

    // Shipping method step: submit selected option via POST.
    if (window.location.pathname === '/checkout-shipping') {
        const shippingSummaryAmount = document.getElementById('shipping-summary-amount');
        const shippingSummaryTotal = document.getElementById('shipping-summary-total');
        const subtotalNode = document.querySelector('.summary-totals .total-row span:last-child');
        const parsedSubtotal = subtotalNode ? parseFloat((subtotalNode.textContent || '').replace(/[^0-9.]/g, '')) : 0;
        const shippingOptions = document.querySelectorAll('input[name="shipping_method"]');

        shippingOptions.forEach(option => {
            option.addEventListener('change', function() {
                document.querySelectorAll('.shipping-option').forEach(opt => opt.classList.remove('selected'));
                if (this.checked) {
                    this.closest('.shipping-option')?.classList.add('selected');
                }

                const shippingCost = this.value === 'priority' ? 10 : 0;
                if (shippingSummaryAmount) {
                    shippingSummaryAmount.textContent = shippingCost > 0 ? `$${shippingCost.toFixed(2)}` : 'FREE';
                }
                if (shippingSummaryTotal) {
                    shippingSummaryTotal.textContent = `$${(parsedSubtotal + shippingCost).toFixed(2)}`;
                }
            });
        });

        const continueBtn = document.querySelector('a.continue-btn');
        if (continueBtn) {
            continueBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const selected = document.querySelector('input[name="shipping_method"]:checked')?.value || 'free';
                const shippingMethod = selected === 'priority' ? 'paid' : selected;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/checkout-shipping';
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = csrfToken;
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = 'shipping_method';
                method.value = shippingMethod;
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            });
        }
    }

    // Payment step: submit selected method via POST.
    if (window.location.pathname === '/payment' && payBtn) {
        payBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value || 'credit_card';
            const stripeError = document.getElementById('stripe-card-error');
            if (stripeError) {
                stripeError.style.display = 'none';
                stripeError.textContent = '';
            }

            if (paymentMethod === 'paypal') {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/checkout-place-order';
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = csrfToken;
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = 'payment_method';
                method.value = paymentMethod;
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
                return;
            }

            if (!stripe || !cardNumber) {
                if (stripeError) {
                    stripeError.textContent = 'Stripe is not configured. Please add STRIPE_PUBLIC key.';
                    stripeError.style.display = 'block';
                }
                return;
            }

            payBtn.disabled = true;
            const originalText = payBtn.textContent;
            payBtn.textContent = 'Processing...';

            try {
                const intentResponse = await fetch('/payment/stripe/intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const intentPayload = await intentResponse.json();
                if (!intentResponse.ok || !intentPayload.client_secret) {
                    throw new Error(intentPayload.message || 'Unable to initialize card payment.');
                }

                const cardholderName = document.getElementById('stripe-cardholder-name')?.value || '';
                const billingEmail = document.querySelector('.review-row .review-value')?.textContent?.trim() || '';
                const result = await stripe.confirmCardPayment(intentPayload.client_secret, {
                    payment_method: {
                        card: cardNumber,
                        billing_details: {
                            name: cardholderName || undefined,
                            email: billingEmail || undefined
                        }
                    }
                });

                if (result.error) {
                    throw new Error(result.error.message || 'Card payment failed.');
                }

                if (!result.paymentIntent || result.paymentIntent.status !== 'succeeded') {
                    throw new Error('Card payment not completed.');
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/checkout-place-order';

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = csrfToken;

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = 'payment_method';
                method.value = 'credit_card';

                const intentId = document.createElement('input');
                intentId.type = 'hidden';
                intentId.name = 'stripe_payment_intent_id';
                intentId.value = result.paymentIntent.id;

                form.appendChild(token);
                form.appendChild(method);
                form.appendChild(intentId);
                document.body.appendChild(form);
                form.submit();
            } catch (err) {
                if (stripeError) {
                    stripeError.textContent = err.message || 'Payment failed.';
                    stripeError.style.display = 'block';
                } else {
                    showUiMessage('error', err.message || 'Payment failed.');
                }
                payBtn.disabled = false;
                payBtn.textContent = originalText;
            }
        });
    }
});
