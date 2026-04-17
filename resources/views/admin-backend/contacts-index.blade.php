@extends('admin-backend.main.panel')
@section('title', 'Contact Inquiries')
@section('panel-content')
<h1 class="h3 mb-3">Contact Inquiries</h1>
<div class="card">
    <div class="card-body">
    @foreach ($inquiries as $inquiry)
        <div class="border rounded p-3 mb-2">
            <p><strong>{{ $inquiry->name }}</strong> - {{ $inquiry->email }}</p>
            <p>{{ $inquiry->subject }}</p>
            <p>{{ $inquiry->message }}</p>
        </div>
    @endforeach
    {{ $inquiries->links() }}
    </div>
</div>
@endsection
