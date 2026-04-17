@extends('admin-backend.main.panel')
@section('title', 'Orders')
@section('panel-content')
<h1 class="h3 mb-3">Orders</h1>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="orders-table" class="table table-striped table-bordered nowrap w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                        <th>Shipping</th>
                        <th>Total</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ strtoupper($order->payment_method) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>${{ number_format($order->subtotal, 2) }}</td>
                            <td>${{ number_format($order->shipping_cost, 2) }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>{{ $order->created_at }}</td>
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
        $('#orders-table').DataTable({
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
