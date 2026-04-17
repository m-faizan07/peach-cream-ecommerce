@extends('admin-backend.main.panel')
@section('title', 'Orders')
@section('panel-content')
<h1 class="h3 mb-3">Orders</h1>
<div class="card">
    <div class="card-body">
    @foreach ($orders as $order)
        <div class="border rounded p-3 mb-2">#{{ $order->id }} | {{ $order->email }} | ${{ number_format($order->total, 2) }} | {{ $order->status }}</div>
    @endforeach
    {{ $orders->links() }}
    </div>
</div>
@endsection
