@extends('admin-backend.main.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<style>
    .avatar {
        object-fit: cover;
    }

    /* Keep DataTables pagination consistent even with global list styles */
    .dataTables_wrapper .dataTables_paginate ul.pagination {
        display: flex !important;
        flex-wrap: wrap;
        align-items: center;
        gap: .25rem;
        margin: 0;
        padding-left: 0;
        list-style: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .page-item {
        list-style: none !important;
    }

    .dataTables_wrapper .dataTables_paginate .page-link {
        border-radius: .375rem;
    }

    .dataTables_wrapper .dt-buttons {
        display: flex !important;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: center;
        gap: .35rem;
        margin-bottom: .5rem;
    }

    .dataTables_wrapper .dt-buttons .btn {
        margin: 0 !important;
        width: auto !important;
        min-width: 0 !important;
        flex: 0 0 auto !important;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        padding: .35rem .6rem;
        font-size: .8rem;
        line-height: 1.2;
    }

    .dataTables_wrapper .dataTables_scrollBody {
        overflow-x: auto !important;
    }

    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            margin-bottom: .5rem;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            width: 100%;
            max-width: 100%;
            margin-left: 0;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper .dt-buttons .btn {
            padding: .3rem .55rem;
            font-size: .75rem;
        }
    }
</style>
@endpush

@section('content')
@php
    $authUser = auth()->user();
    $profileImageUrl = !empty($authUser->profile_image)
        ? asset('storage/' . $authUser->profile_image)
        : asset('frontend/images/doc.jpg');
@endphp
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                <span class="align-middle">Peach Admin</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">Ecommerce Modules</li>
                <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.products.index') }}">
                        <i class="align-middle" data-feather="package"></i> <span class="align-middle">Products</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.orders.index') }}">
                        <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Orders</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.subscribers.index') }}">
                        <i class="align-middle" data-feather="mail"></i> <span class="align-middle">Subscribers</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.profile.show') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item {{ request()->routeIs('admin.settings.privacy.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.settings.privacy.show') }}">
                        <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings & Privacy</span>
                    </a>
                </li>

                <li class="sidebar-header">Coming Soon</li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="truck"></i>
                        <span class="align-middle">Shipping Module</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="archive"></i>
                        <span class="align-middle">Inventory Management</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="rotate-ccw"></i>
                        <span class="align-middle">Returns Center</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="tag"></i>
                        <span class="align-middle">Coupon Manager</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="percent"></i>
                        <span class="align-middle">Discount Rules</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="gift"></i>
                        <span class="align-middle">Gift Cards</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="users"></i>
                        <span class="align-middle">Customers</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="message-square"></i>
                        <span class="align-middle">Support Tickets</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="send"></i>
                        <span class="align-middle">Email Campaigns</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="bar-chart-2"></i>
                        <span class="align-middle">Sales Reports</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="activity"></i>
                        <span class="align-middle">Traffic Analytics</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="credit-card"></i>
                        <span class="align-middle">Payments</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault();">
                        <i class="align-middle" data-feather="shield"></i>
                        <span class="align-middle">Fraud Protection</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.settings.privacy.show') }}">
                        <i class="align-middle" data-feather="settings"></i>
                        <span class="align-middle">Store Settings</span>
                        
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();">
                        <i class="align-middle" data-feather="log-out"></i>
                        <span class="align-middle">Sign Out</span>
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
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="position-relative">
                                <i class="align-middle" data-feather="bell"></i>
                                <span class="indicator">4</span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-2" aria-labelledby="alertsDropdown">
                            <span class="dropdown-item-text text-muted small">4 new notifications</span>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-inline-block" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ $profileImageUrl }}" class="avatar img-fluid rounded me-1" alt="Profile" width="36" height="36" />
                            <span class="text-dark d-none d-md-inline">{{ $authUser->name ?? 'Admin User' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                <i class="align-middle me-1" data-feather="user"></i> Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.settings.privacy.show') }}">
                                <i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();">
                                <i class="align-middle me-1" data-feather="log-out"></i> Log out
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <form id="nav-logout-form" method="POST" action="{{ route('admin.logout') }}" class="d-none">
            @csrf
        </form>

        <main class="content">
            <div class="container-fluid p-0">
                @yield('panel-content')
            </div>
        </main>
    </div>
</div>

<script src="{{ asset('admin-panel/js/app.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
@stack('panel-scripts')
@endsection
