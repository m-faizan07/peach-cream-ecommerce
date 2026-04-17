@extends('frontend.main.app')

@section('title', 'Shipping Method | Peach Cream')

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
                        <span class="active">Shipping</span>
                        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
                        <span>Payment</span>
                    </nav>
                </header>

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
                </div>

                <div class="shipping-method-section">
                    <h2>Shipping Method</h2>
                    <p class="shipping-sub">First Shipment</p>
                    
                    <div class="shipping-options-box">
                        <label class="shipping-option {{ ($shippingMethod ?? 'free') === 'free' ? 'selected' : '' }}">
                            <input type="radio" name="shipping_method" value="free" {{ ($shippingMethod ?? 'free') === 'free' ? 'checked' : '' }}>
                            <span class="radio-custom"></span>
                            <div class="option-info">
                                <span class="option-name">5 to 8 business days • Orders $99.01 and up</span>
                            </div>
                            <span class="option-price">FREE</span>
                        </label>
                        <label class="shipping-option {{ ($shippingMethod ?? 'free') === 'paid' ? 'selected' : '' }}">
                            <input type="radio" name="shipping_method" value="priority" {{ ($shippingMethod ?? 'free') === 'paid' ? 'checked' : '' }}>
                            <span class="radio-custom"></span>
                            <div class="option-info">
                                <span class="option-name">Priority 2-3 Business Days</span>
                            </div>
                            <span class="option-price">$10.00</span>
                        </label>
                    </div>

                    <div class="recurring-shipments">
                        <p class="shipping-sub">Recurring shipments</p>
                        <div class="recurring-box">
                            5 to 8 business days • Orders $99.01 and up
                        </div>
                    </div>
                </div>

                <div class="checkout-form-footer">
                    <a href="{{ route('frontend.shipping') }}" class="return-link">
                        <i class="fa-solid fa-chevron-left"></i>
                        Return to information
                    </a>
                    <a href="{{ route('frontend.payment') }}" class="continue-btn" style="text-decoration:none; display:inline-block; text-align:center;">Continue To Payment</a>
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
                        <span id="shipping-summary-amount">{{ ($shippingCost ?? 0) > 0 ? '$' . number_format($shippingCost, 2) : 'FREE' }}</span>
                    </div>
                    <div class="total-row">
                        <span>Estimated Taxes</span>
                        <span>$0.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total</span>
                        <div class="total-price">
                            <span class="currency">USD</span>
                            <span class="price" id="shipping-summary-total">${{ number_format($subtotal + ($shippingCost ?? 0), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    
@endsection
