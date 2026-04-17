@extends('admin-backend.main.panel')
@section('title', 'Subscribers')
@section('panel-content')
<h1 class="h3 mb-3">Subscribers</h1>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="subscribers-table" class="table table-striped table-bordered nowrap w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Subscribed At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td>{{ $subscription->email }}</td>
                            <td>{{ $subscription->created_at }}</td>
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
        $('#subscribers-table').DataTable({
            responsive: false,
            scrollX: true,
            autoWidth: false,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
        });
    });
</script>
@endpush
