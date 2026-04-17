@extends('frontend.main.app')

@section('title', 'Empty Cart | Peach Cream')

@section('content')

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('frontend.home') }}">Home</a>
        <span class="sep"><i class="fa-solid fa-chevron-right"></i></span>
        <span class="current">Peach Cream</span>
    </div>

    <!-- Empty Cart Section -->
    <section class="cart-section empty-cart-section">
        <h1 class="cart-title">Your Shopping Cart</h1>

        <div class="empty-cart-content">
            <p>Your cart is currently empty. <a href="{{ route('frontend.product') }}">Back to shopping</a></p>
        </div>
    </section>

@endsection