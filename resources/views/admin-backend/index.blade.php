@extends('admin-backend.main.panel')
@section('title', 'Admin Dashboard')
@section('panel-content')
<h1 class="h3 mb-3">Dashboard</h1>
<div class="row">
    <div class="col-md-4 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title">Orders</h5>
                <h2 class="mb-0">{{ $ordersCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title">Pending Reviews</h5>
                <h2 class="mb-0">{{ $pendingReviews }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title">Subscribers</h5>
                <h2 class="mb-0">{{ $newsletterCount }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection