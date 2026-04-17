@extends('frontend.main.app')

@section('title', 'Payment Selection | Peach Cream')

@section('content')
    <div class="checkout-layout">
        <!-- Left: Form Section -->
        <main class="checkout-main">
            <div class="checkout-content">
                <header class="checkout-header-centered">
                    <a href="{{ route('frontend.home') }}" class="checkout-logo-centered">
                        <img src="images/peachlogo.png" alt="Peach Cream Logo">
                        <h1>Peach Cream</h1>
                    </a>
                    <nav class="checkout-breadcrumb-centered">
                        <a href="{{ route('frontend.cart') }}">Cart</a>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <a href="{{ route('frontend.shipping') }}">Information</a>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <a href="{{ route('frontend.checkout-shipping') }}">Shipping</a>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <span class="active">Payment</span>
                    </nav>
                </header>

                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-bottom: 16px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="checkout-review-box">
                    <div class="review-row">
                        <span class="review-label">Contact</span>
                        <span class="review-value">raam2@gmail.com</span>
                        <a href="{{ route('frontend.shipping') }}" class="review-change">change</a>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Ship To</span>
                        <span class="review-value">cdfdf, Lahore AL 35001, United States</span>
                        <a href="{{ route('frontend.shipping') }}" class="review-change">change</a>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Method</span>
                        <span class="review-value">
                            {{ ($checkout['shipping_method'] ?? 'free') === 'paid' ? 'Priority 2-3 Business Days • $10.00' : '5 to 8 business days • FREE' }}
                        </span>
                        <a href="{{ route('frontend.checkout-shipping') }}" class="review-change">change</a>
                    </div>
                </div>

                <div class="payment-section">
                    <h2>Payment</h2>
                    <p class="payment-sub">All transactions are secure and encrypted.</p>

                    <div class="payment-options-box">
                        <!-- Credit Card Option -->
                        <div class="payment-method-option {{ ($checkout['payment_method'] ?? 'credit_card') === 'credit_card' ? 'selected' : '' }}">
                            <label class="method-header">
                                <div class="header-left">
                                    <input type="radio" name="payment_method" value="credit_card" id="method-cc"
                                        {{ ($checkout['payment_method'] ?? 'credit_card') === 'credit_card' ? 'checked' : '' }}>
                                    <span class="radio-custom"></span>
                                    <span class="method-name">Credit card</span>
                                </div>
                                <div class="card-icons">
                                    <img src="images/visa.png" alt="Visa">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                        alt="Mastercard">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                                        alt="PayPal">
                                </div>
                            </label>

                            <div class="payment-fields">
                                <div class="field-container">
                                    <div class="form-input" id="stripe-card-number"></div>
                                    <i class="fa-solid fa-lock field-icon"></i>
                                </div>
                                <div class="form-row">
                                    <div class="form-input" id="stripe-card-expiry"></div>
                                    <div class="field-container">
                                        <div class="form-input" id="stripe-card-cvc"></div>
                                        <i class="fa-solid fa-circle-question field-icon"></i>
                                    </div>
                                </div>
                                <input type="text" placeholder="Name on card" class="form-input" id="stripe-cardholder-name">
                                <p id="stripe-card-error" style="color:#d32f2f; margin-top:8px; display:none;"></p>
                            </div>
                        </div>

                        <!-- PayPal Option -->
                        <div class="payment-method-option {{ ($checkout['payment_method'] ?? 'credit_card') === 'paypal' ? 'selected' : '' }}">
                            <label class="method-header">
                                <div class="header-left">
                                    <input type="radio" name="payment_method" value="paypal" id="method-paypal" {{ ($checkout['payment_method'] ?? 'credit_card') === 'paypal' ? 'checked' : '' }}>
                                    <span class="radio-custom"></span>
                                    <span class="method-name">PayPal</span>
                                </div>
                                <div class="card-icons">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                                        alt="PayPal">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="billing-section">
                    <h2>Billing address</h2>
                    <p class="billing-sub">Select the address that matches your card or payment method.</p>

                    <div class="billing-options-box">
                        <label class="billing-option selected">
                            <input type="radio" name="billing_address" value="same" id="billing-same" checked>
                            <span class="radio-custom"></span>
                            <span class="option-text">Same as shipping address</span>
                        </label>
                        <label class="billing-option">
                            <input type="radio" name="billing_address" value="different" id="billing-different">
                            <span class="radio-custom"></span>
                            <span class="option-text">Use a different billing address</span>
                        </label>

                        <!-- Hidden Billing Form -->
                        <div id="billing-address-form" class="billing-address-form hidden">
                            <select class="form-input">
                                <option>United States</option>
                            </select>
                            <div class="form-row">
                                <input type="text" placeholder="First name" class="form-input">
                                <input type="text" placeholder="Last name" class="form-input">
                            </div>
                            <input type="text" placeholder="Company (optional)" class="form-input">
                            <div class="field-container">
                                <input type="text" placeholder="Address" class="form-input">
                                <i class="fa-solid fa-search field-icon"></i>
                            </div>
                            <input type="text" placeholder="Apartment, suite, etc. (optional)" class="form-input">
                            <div class="form-row three-col">
                                <input type="text" placeholder="City" class="form-input">
                                <select class="form-input">
                                    <option>State</option>
                                </select>
                                <input type="text" placeholder="ZIP code" class="form-input">
                            </div>
                            <div class="field-container">
                                <input type="tel" placeholder="Phone (optional)" class="form-input">
                                <i class="fa-solid fa-circle-question field-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="save-info-section">
                    <h2>Save my information for a faster checkout</h2>
                    <div class="mobile-number-input-field">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <div class="input-content">
                            <label>Mobile Number</label>
                            <input type="tel" value="+1" placeholder="">
                        </div>
                    </div>
                    <p class="save-info-note">By providing your phone number, you agree to create a Shop account subject
                        to Shop's Terms and Privacy Policy.</p>
                    <p class="secondary-legal-text">
                        One or more items in your cart is a deferred, subscription, or recurring purchase. By continuing
                        with your payment, you agree that your payment method will automatically be charged at the price
                        and frequency listed on this page until it ends or you cancel. All cancellations are subject to
                        the cancellation policy.
                    </p>
                </div>

                <div class="checkout-form-footer">
                    <a href="{{ route('frontend.checkout-shipping') }}" class="return-link">
                        <i class="fa-solid fa-chevron-left"></i>
                        Return to shipping
                    </a>
                    <button type="button" class="continue-btn" id="pay-now-btn">Pay Now</button>
                </div>

                <footer class="checkout-footer">
                    <a href="#">Refund policy</a>
                    <a href="#">Shipping policy</a>
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms of service</a>
                    <a href="#">Cancellations</a>
                </footer>
            </div>
        </main>

        <!-- Right: Order Summary Section -->
        <aside class="order-summary">
            <div class="summary-content">
                <div class="summary-items">
                    <div class="summary-item">
                        <div class="item-img-box">
                            <img src="images/what-make-you-happy.png" alt="Peach Cream">
                            <span class="item-qty-badge">{{ $qty }}</span>
                        </div>
                        <div class="item-info">
                            <p class="item-name">Peach Cream</p>
                            <p class="item-variant">1 Bottle</p>
                        </div>
                        <p class="item-price">${{ number_format($subtotal, 2) }}</p>
                    </div>
                </div>

                <div class="summary-totals">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Shipping</span>
                        <span>{{ $shippingCost > 0 ? '$' . number_format($shippingCost, 2) : 'Free' }}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <div class="total-price">
                            <span class="currency">USD</span>
                            <span class="price">${{ number_format($subtotal + $shippingCost, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.checkoutStripePublicKey = @json($stripePublicKey ?? '');
    </script>
@endpush