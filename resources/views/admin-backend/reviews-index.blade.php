@extends('admin-backend.main.panel')
@section('title', 'Reviews')
@section('panel-content')
<h1 class="h3 mb-3">Reviews</h1>
<div class="card">
    <div class="card-body">
    @foreach ($reviews as $review)
        <div class="border rounded p-3 mb-2">
            <p>{{ $review->name }} ({{ $review->rating }}/5) - {{ $review->status }}</p>
            <p>{{ $review->comment }}</p>
            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display:inline">@csrf <button class="btn btn-sm btn-success">Approve</button></form>
            <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" style="display:inline">@csrf <button class="btn btn-sm btn-outline-danger">Reject</button></form>
        </div>
    @endforeach
    {{ $reviews->links() }}
    </div>
</div>
@endsection
