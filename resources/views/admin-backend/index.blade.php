@extends('admin-backend.main.panel')
@section('title', 'Admin Dashboard')
@section('panel-content')
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

<div class="row">
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title mb-1">Sales</h5>
                <h2 class="mb-1">${{ number_format($salesTotal, 2) }}</h2>
                <small class="{{ $salesChange >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($salesChange, 2) }}% since last week
                </small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title mb-1">Orders</h5>
                <h2 class="mb-1">{{ $ordersThisWeek }}</h2>
                <small class="{{ $ordersChange >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ number_format($ordersChange, 2) }}% since last week
                </small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title mb-1">Pending Reviews</h5>
                <h2 class="mb-1">{{ $pendingReviews }}</h2>
                <small class="text-muted">Awaiting moderation</small>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h5 class="card-title mb-1">Subscribers</h5>
                <h2 class="mb-1">{{ $newsletterCount }}</h2>
                <small class="text-muted">Newsletter audience</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Monthly Sales</h5>
            </div>
            <div class="card-body">
                <div class="chart chart-lg">
                    <canvas id="dashboard-monthly-sales"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Calendar</h5>
            </div>
            <div class="card-body">
                <div id="dashboard-calendar"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Latest Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ strtoupper($order->payment_method) }}</td>
                                    <td>{{ ucfirst($order->status) }}</td>
                                    <td>${{ number_format((float) $order->total, 2) }}</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('panel-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlySales = @json($monthlySales);
        const salesChart = document.getElementById('dashboard-monthly-sales');
        if (salesChart && window.Chart) {
            new Chart(salesChart, {
                type: 'bar',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                    datasets: [{
                        label: 'Sales (USD)',
                        data: monthlySales,
                        backgroundColor: '#3b7ddd'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        }

        const calendar = document.getElementById('dashboard-calendar');
        if (calendar && window.flatpickr) {
            window.flatpickr(calendar, {
                inline: true,
                defaultDate: 'today'
            });
        }
    });
</script>
@endpush