@extends('admin-backend.main.panel')
@section('title', 'Manage Product')
@section('panel-content')
<h1 class="h3 mb-3">Manage Product</h1>
@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif
<div class="card mb-4">
    <div class="card-body">
    <form method="POST" action="{{ route('admin.products.update') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6"><label class="form-label">Title</label><input class="form-control" name="title" value="{{ old('title', $product->title) }}" required></div>
        <div class="col-md-6"><label class="form-label">Main Image</label><input class="form-control" type="file" name="main_image"></div>
        <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="4">{{ old('description', $product->description) }}</textarea></div>
        <div class="col-md-4"><label class="form-label">Quantity</label><input class="form-control" type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" required></div>
        <div class="col-md-4"><label class="form-label">Price</label><input class="form-control" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required></div>
        <div class="col-md-4"><label class="form-label">Discount</label><input class="form-control" type="number" step="0.01" name="discount" value="{{ old('discount', $product->discount) }}"></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Save Product</button></div>
    </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
    <h3 class="h5">Sub Images</h3>
    <form method="POST" action="{{ route('admin.products.images.store') }}" enctype="multipart/form-data" class="d-flex gap-2 mb-3">@csrf <input class="form-control" type="file" name="image" required><button class="btn btn-outline-primary">Add Image</button></form>
    @foreach ($product->images as $image)
        <div class="d-flex justify-content-between align-items-center border p-2 mb-2 rounded">
            <span>{{ $image->image_path }}</span>
            <form method="POST" action="{{ route('admin.products.images.delete', $image) }}">@csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button></form>
        </div>
    @endforeach
    </div>
</div>

<div class="card">
    <div class="card-body">
    <h3 class="h5">Accordions</h3>
    <form method="POST" action="{{ route('admin.products.accordions.store') }}" class="row g-2 mb-3">
        @csrf
        <div class="col-md-3"><input class="form-control" name="title" placeholder="Accordion title" required></div>
        <div class="col-md-5"><textarea class="form-control" name="content" placeholder="Accordion content"></textarea></div>
        <div class="col-md-2"><input class="form-control" name="background_color" placeholder="#fff5f8"></div>
        <div class="col-md-2"><button class="btn btn-outline-primary w-100">Add Accordion</button></div>
    </form>
    @foreach ($product->accordions as $accordion)
        <div class="d-flex justify-content-between align-items-center border p-2 mb-2 rounded">
            <span>{{ $accordion->title }} - {{ $accordion->background_color }}</span>
            <form method="POST" action="{{ route('admin.products.accordions.delete', $accordion) }}">@csrf @method('DELETE') <button class="btn btn-sm btn-outline-danger">Delete</button></form>
        </div>
    @endforeach
    </div>
</div>
@endsection
