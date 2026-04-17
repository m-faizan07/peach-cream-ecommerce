@extends('admin-backend.main.panel')
@section('title', 'Products')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="products-table" class="table table-striped table-bordered nowrap w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Original Price</th>
                        <th>Sale Price</th>
                        <th>Qty</th>
                        <th>Reviews</th>
                        <th>Rating</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>${{ number_format((float) ($product->original_price ?? 0), 2) }}</td>
                            <td>${{ number_format((float) $product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->review_count ?? 0 }}</td>
                            <td>{{ number_format((float) ($product->rating_value ?? 5), 1) }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirmWithSweetAlert(event, this.form, 'Delete this product?')"
                                        type="submit"
                                    >
                                        Delete
                                    </button>
                                </form>
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
    function confirmWithSweetAlert(event, form, message) {
        event.preventDefault();

        if (window.Swal) {
            Swal.fire({
                icon: 'warning',
                title: 'Please confirm',
                text: message,
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
            return false;
        }

        return window.confirm(message);
    }

    $(function () {
        $('#products-table').DataTable({
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
