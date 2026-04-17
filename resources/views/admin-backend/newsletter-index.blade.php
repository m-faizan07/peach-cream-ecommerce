@extends('admin-backend.main.panel')
@section('title', 'Subscribers')
@section('panel-content')
<h1 class="h3 mb-3">Subscribers</h1>
<div class="card">
    <div class="card-body">
    @foreach ($subscriptions as $subscription)
        <div class="border rounded p-3 mb-2">{{ $subscription->email }} ({{ $subscription->created_at }})</div>
    @endforeach
    {{ $subscriptions->links() }}
    </div>
</div>
@endsection
