@extends('admin-backend.main.panel')
@section('title', 'Reviews')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Reviews</h1>
</div>

<div class="card">
    <div class="card-body py-5">
        <div class="text-center mb-4">
            <h2 class="h3 mb-2">Reviews Module Coming Soon</h2>
            <p class="text-muted mb-0">
                We are preparing an upgraded review moderation workspace for your store.
            </p>
        </div>

        <div class="row g-3 justify-content-center" style="max-width: 820px; margin: 0 auto;">
            <div class="col-md-6">
                <div class="border rounded p-3 h-100 bg-light">
                    <h6 class="mb-2">What is coming next</h6>
                    <ul class="mb-0 ps-3">
                        <li>Smart spam detection and auto-filtering</li>
                        <li>Bulk approve/reject actions</li>
                        <li>Rating analytics and trends</li>
                        <li>Customer reply workflow</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3 h-100 bg-light">
                    <h6 class="mb-2">Planned eCommerce modules</h6>
                    <ul class="mb-0 ps-3">
                        <li>Shipping Module</li>
                        <li>Inventory Management</li>
                        <li>Returns Management</li>
                        <li>Coupon & Promotions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
