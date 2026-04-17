@extends('admin-backend.main.panel')
@section('title', 'Reviews')
@section('panel-content')
<h1 class="h3 mb-3">Reviews</h1>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="reviews-table" class="table table-striped table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviews as $review)
                        <tr>
                            <td>#{{ $review->id }}</td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->email }}</td>
                            <td>{{ $review->rating }}/5</td>
                            <td>{{ ucfirst($review->status) }}</td>
                            <td>{{ $review->comment }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" style="display:inline">@csrf <button class="btn btn-sm btn-success">Approve</button></form>
                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" style="display:inline">@csrf <button class="btn btn-sm btn-outline-danger">Reject</button></form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('panel-scripts')
<script>
    $(function () {
        $('#reviews-table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        });
    });
</script>
@endpush
