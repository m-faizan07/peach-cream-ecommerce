@extends('admin-backend.main.panel')
@section('title', 'Settings & Privacy')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Settings & Privacy</h1>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-4">
            These fallback values are used only when no product exists in the database.
            If at least one product is found, product values override these settings.
        </p>

        <form method="POST" action="{{ route('admin.settings.privacy.update') }}" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Fallback Quantity</label>
                <input class="form-control" type="number" min="0" name="fallback_quantity" value="{{ old('fallback_quantity', $settings->fallback_quantity) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fallback Original Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="fallback_original_price" value="{{ old('fallback_original_price', $settings->fallback_original_price) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fallback Sale Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="fallback_sale_price" value="{{ old('fallback_sale_price', $settings->fallback_sale_price) }}" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
