@extends('admin-backend.main.app')

@section('content')
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                <span class="align-middle">Peach Admin</span>
            </a>

            <ul class="sidebar-nav">
                <!-- <li class="sidebar-header">Ecommerce Modules</li> -->
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.orders.index') }}">
                        <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Orders</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.reviews.index') }}">
                        <i class="align-middle" data-feather="star"></i> <span class="align-middle">Reviews</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.subscribers.index') }}">
                        <i class="align-middle" data-feather="mail"></i> <span class="align-middle">Subscribers</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="content">
            <div class="container-fluid p-0">
                @yield('panel-content')
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('admin-panel/js/app.js') }}"></script>
@endsection
