@extends('frontend.main.app')

@section('title', 'Shopping Cart | Peach Cream')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('frontend.home') }}">Home</a>
        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
        <span class="current">Peach Cream</span>
    </div>

    <!-- Cart Section -->
    <section class="cart-section">
        <h1 class="cart-title">Your Shopping Cart</h1>

        <div class="cart-container">
            <!-- Cart Table Headers -->
            <div class="cart-header">
                <div class="header-product">PRODUCT</div>
                <div class="header-qty">QUANTITY</div>
                <div class="header-total">TOTAL</div>
            </div>

            <!-- Cart Items -->
            <div class="cart-items">
                <div class="cart-item">
                    <div class="item-product">
                        <div class="item-img">
                            <img src="images/what-make-you-happy.png" alt="Peach Cream">
                        </div>
                        <div class="item-details">
                            <h3>Peach Cream</h3>
                            <p class="item-price">${{ number_format($unit, 2) }}</p>
                            <p class="item-meta">Pack Size: 1 Bottle</p>
                        </div>
                    </div>
                    <div class="item-qty">
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateCartQty(-1)">-</button>
                            <input type="number" class="qty-input" value="{{ $qty }}" min="1">
                            <button class="qty-btn" onclick="updateCartQty(1)">+</button>
                        </div>
                        <button class="remove-btn"><i class="fa-regular fa-trash-can"></i></button>
                    </div>
                    <div class="item-total">${{ number_format($subtotal, 2) }}</div>
                </div>
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <a href="{{ route('frontend.product') }}" class="action-btn outline">Return to product</a>
                <a href="#" id="clear-cart-link" class="action-btn outline">Clear Shopping Cart</a>
            </div>

            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal:</span>
                        <span class="summary-value">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <p class="summary-note">Taxes and shipping calculated at checkout.</p>
                    <a href="{{ route('frontend.shipping') }}" class="checkout-btn"
                        style="text-decoration:none; display:inline-block; text-align:center;">Check out</a>
                </div>
            </div>
        </div>
    </section>

@endsection