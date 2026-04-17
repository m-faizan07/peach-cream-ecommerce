@extends('frontend.main.app')

@section('title', 'Checkout | Peach Cream')

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
                        <span class="active">Information</span>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <span>Shipping</span>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <span>Payment</span>
                    </nav>
                </header>

                <div class="express-checkout">
                    <p class="express-title">Express Checkout</p>
                    <div class="express-buttons">
                        <button class="express-btn shop-pay"><img src="images/Mastercard.svg" alt="Shop Pay"></button>
                        <button class="express-btn paypal"><img
                                src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                                alt="PayPal"></button>
                        <button class="express-btn gpay"><img src="images/GooglePay.svg" alt="Google Pay"></button>
                    </div>
                </div>

                <div class="separator">
                    <span>OR</span>
                </div>

                <form class="checkout-form">
                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom:16px;">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div class="form-section">
                        <div class="section-header">
                            <h2>Contact</h2>
                            <!-- <a href="#" class="login-link">Sign in</a> -->
                        </div>
                        <input type="email" placeholder="Email" class="form-input" required value="{{ old('email', $checkout['email'] ?? '') }}">
                        <div class="checkbox-group">
                            <input type="checkbox" id="email-me">
                            <label for="email-me">Email me with news and offers</label>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Shipping Address</h2>
                        <select class="form-input">
                            <option>United States</option>
                        </select>
                        <div class="form-row">
                            <input type="text" placeholder="First name" class="form-input" required value="{{ old('first_name', explode(' ', $checkout['shipping_name'] ?? '', 2)[0] ?? '') }}">
                            <input type="text" placeholder="Last name" class="form-input" required value="{{ old('last_name', explode(' ', $checkout['shipping_name'] ?? '', 2)[1] ?? '') }}">
                        </div>
                        <input type="text" placeholder="Company (optional)" class="form-input">
                        <input type="text" placeholder="Address" class="form-input" required value="{{ old('address', $checkout['shipping_line1'] ?? '') }}">
                        <input type="text" placeholder="Apartment, suite, etc. (optional)" class="form-input">
                        <div class="form-row three-col">
                            <input type="text" placeholder="City" class="form-input" required value="{{ old('city', $checkout['shipping_city'] ?? '') }}">
                            <select class="form-input">
                                <option value="">State</option>
                                <option value="California" {{ old('state', $checkout['shipping_state'] ?? '') === 'California' ? 'selected' : '' }}>California</option>
                                <option value="Texas" {{ old('state', $checkout['shipping_state'] ?? '') === 'Texas' ? 'selected' : '' }}>Texas</option>
                                <option value="Florida" {{ old('state', $checkout['shipping_state'] ?? '') === 'Florida' ? 'selected' : '' }}>Florida</option>
                                <option value="New York" {{ old('state', $checkout['shipping_state'] ?? '') === 'New York' ? 'selected' : '' }}>New York</option>
                                <option value="Illinois" {{ old('state', $checkout['shipping_state'] ?? '') === 'Illinois' ? 'selected' : '' }}>Illinois</option>
                            </select>
                            <input type="text" placeholder="ZIP code" class="form-input" required value="{{ old('zipcode', $checkout['shipping_zipcode'] ?? '') }}">
                        </div>
                        <input type="tel"
                            placeholder="Enter mobile # for order & shipping text updates. Reply STOP to uns...."
                            class="form-input" value="{{ old('mobile', $checkout['phone'] ?? '') }}">
                        <div class="checkout-legal-checkbox">
                            <input type="checkbox" id="sms-consent">
                            <label for="sms-consent">
                                By signing up via text, you agree to receive recurring automated marketing messages,
                                including cart reminders, from Hem Healer® at the phone number provided. Consent is not
                                a condition of purchase. Reply STOP to unsubscribe. Reply HELP for help. Message
                                frequency varies. Msg & data rates may apply. View our Privacy Policy and Terms of
                                Service.
                            </label>
                        </div>

                        <!-- Hidden Section revealed on Tick -->
                        <div id="sms-disclosure-section" class="hidden">
                            <div class="mobile-number-input-field">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                                <div class="input-content">
                                    <label>Mobile Number</label>
                                    <input type="tel" value="+1" placeholder="">
                                </div>
                            </div>
                            <p class="error-msg">Enter a valid number</p>

                            <p class="secondary-legal-text">
                                By signing up via text, you agree to receive recurring automated marketing messages,
                                including cart reminders, from Hem Healer® at the phone number provided. Consent is not
                                a condition of purchase. Reply STOP to unsubscribe. Reply HELP for help. Message
                                frequency varies. Msg & data rates may apply. View our Privacy Policy and Terms of
                                Service.
                            </p>
                        </div>
                    </div>

                    <div class="checkout-form-footer">
                        <a href="{{ route('frontend.cart') }}" class="return-link">
                            <i class="fa-solid fa-chevron-left"></i>
                            Return to cart
                        </a>
                        <a href="{{ route('frontend.checkout-shipping') }}" class="continue-btn" style="text-decoration:none; display:inline-block; text-align:center;">Continue To Shipping</a>
                    </div>
                </form>
                <div class="footer-divider"></div>

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
                        <span>Free</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <div class="total-price">
                            <span class="currency">USD</span>
                            <span class="price">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>


@endsection