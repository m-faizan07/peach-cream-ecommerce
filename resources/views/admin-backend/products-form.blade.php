@extends('admin-backend.main.panel')
@section('title', $isEdit ? 'Edit Product' : 'Create Product')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $isEdit ? 'Edit Product' : 'Create Product' }}</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back to list</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input class="form-control" name="title" value="{{ old('title', $product->title) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline</label>
                <input class="form-control" name="tagline" value="{{ old('tagline', $product->tagline) }}" placeholder="Short product tagline">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input class="form-control" type="number" min="0" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Original Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="original_price" value="{{ old('original_price', $product->original_price) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sale Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Review Count</label>
                <input class="form-control" type="number" min="0" name="review_count" value="{{ old('review_count', $product->review_count) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Main Image</label>
                <input class="form-control" type="file" name="main_image">
                @if($isEdit)
                    <div class="mt-2">
                        <div class="small text-muted mb-2">Current main image</div>
                        <img
                            src="{{ $product->main_image ? asset('storage/' . $product->main_image) : asset('frontend/images/what-make-you-happy.png') }}"
                            alt="Main Image"
                            class="img-fluid rounded mb-2"
                            style="max-height:160px;"
                        >
                        @if($product->main_image)
                            <div>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    type="button"
                                    onclick="if(confirm('Remove current main image?')){ document.getElementById('main-image-delete-form').submit(); }"
                                >
                                    Remove Main Image
                                </button>
                            </div>
                        @else
                            <span class="badge bg-secondary">Using static fallback image</span>
                        @endif
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label">Discount</label>
                <input class="form-control" type="number" step="0.01" min="0" name="discount" value="{{ old('discount', $product->discount) }}" readonly>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Badges</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addBadge()">+</button>
                </div>
                <div id="badges-container">
                    @php $oldBadges = old('badges', $badges ?? []); @endphp
                    @forelse($oldBadges as $badge)
                        <div class="input-group mb-2 badge-row">
                            <input class="form-control" name="badges[]" value="{{ $badge }}" placeholder="Badge text">
                            <button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>
                        </div>
                    @empty
                        <div class="input-group mb-2 badge-row">
                            <input class="form-control" name="badges[]" placeholder="Badge text">
                            <button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">Gallery Images</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addGallery()">+</button>
                </div>
                <div id="gallery-container">
                    @php $oldGallery = old('gallery_images', []); @endphp
                    @forelse($oldGallery as $image)
                        <div class="input-group mb-2 gallery-row">
                            <input class="form-control" name="gallery_images[]" type="file" accept="image/*">
                            <button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>
                        </div>
                    @empty
                        <div class="input-group mb-2 gallery-row">
                            <input class="form-control" name="gallery_images[]" type="file" accept="image/*">
                            <button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>
                        </div>
                    @endforelse
                </div>
                @if($isEdit && ($galleryImages ?? collect())->count())
                    <div class="mt-2">
                        <div class="small text-muted mb-2">Existing gallery images</div>
                        <div class="row g-2">
                            @foreach ($galleryImages as $image)
                                <div class="col-md-3 col-6">
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery" class="img-fluid rounded mb-2">
                                        <input type="hidden" name="existing_gallery_images[]" value="{{ $image->image_path }}">
                                        <button
                                            class="btn btn-sm btn-outline-danger w-100"
                                            type="button"
                                            onclick="if(confirm('Delete this gallery image?')){ document.getElementById('gallery-delete-{{ $image->id }}').submit(); }"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0">FAQs</label>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFaq()">+</button>
                </div>
                <div id="faqs-container">
                    @php $oldFaqs = old('faqs', $faqs ?? []); @endphp
                    @forelse($oldFaqs as $index => $faq)
                        <div class="faq-row border rounded p-2 mb-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">Title</span>
                                <input class="form-control" name="faqs[{{ $index }}][title]" value="{{ $faq['title'] ?? '' }}" placeholder="FAQ title">
                                <button class="btn btn-outline-danger" type="button" onclick="removeFaq(this)">-</button>
                            </div>
                            <textarea class="form-control" name="faqs[{{ $index }}][content]" rows="3" placeholder="FAQ content">{{ $faq['content'] ?? '' }}</textarea>
                        </div>
                    @empty
                        <div class="faq-row border rounded p-2 mb-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">Title</span>
                                <input class="form-control" name="faqs[0][title]" placeholder="FAQ title">
                                <button class="btn btn-outline-danger" type="button" onclick="removeFaq(this)">-</button>
                            </div>
                            <textarea class="form-control" name="faqs[0][content]" rows="3" placeholder="FAQ content"></textarea>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Update Product' : 'Create Product' }}</button>
            </div>
        </form>

        @if($isEdit && ($galleryImages ?? collect())->count())
            @foreach ($galleryImages as $image)
                <form id="gallery-delete-{{ $image->id }}" method="POST" action="{{ route('admin.products.gallery.delete', [$product, $image]) }}" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        @endif

        @if($isEdit && $product->main_image)
            <form id="main-image-delete-form" method="POST" action="{{ route('admin.products.main-image.delete', $product) }}" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</div>
@endsection

@push('panel-scripts')
<script>
    function removeRow(button) {
        const row = button.closest('.input-group');
        if (row) row.remove();
    }

    function addBadge() {
        const container = document.getElementById('badges-container');
        const row = document.createElement('div');
        row.className = 'input-group mb-2 badge-row';
        row.innerHTML = '<input class="form-control" name="badges[]" placeholder="Badge text"><button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>';
        container.appendChild(row);
    }

    function addGallery() {
        const container = document.getElementById('gallery-container');
        const row = document.createElement('div');
        row.className = 'input-group mb-2 gallery-row';
        row.innerHTML = '<input class="form-control" name="gallery_images[]" type="file" accept="image/*"><button class="btn btn-outline-danger" type="button" onclick="removeRow(this)">-</button>';
        container.appendChild(row);
    }

    function reindexFaqs() {
        document.querySelectorAll('#faqs-container .faq-row').forEach((row, index) => {
            const title = row.querySelector('input');
            const content = row.querySelector('textarea');
            if (title) title.name = `faqs[${index}][title]`;
            if (content) content.name = `faqs[${index}][content]`;
        });
    }

    function addFaq() {
        const container = document.getElementById('faqs-container');
        const index = container.querySelectorAll('.faq-row').length;
        const row = document.createElement('div');
        row.className = 'faq-row border rounded p-2 mb-2';
        row.innerHTML = `
            <div class="input-group mb-2">
                <span class="input-group-text">Title</span>
                <input class="form-control" name="faqs[${index}][title]" placeholder="FAQ title">
                <button class="btn btn-outline-danger" type="button" onclick="removeFaq(this)">-</button>
            </div>
            <textarea class="form-control" name="faqs[${index}][content]" rows="3" placeholder="FAQ content"></textarea>
        `;
        container.appendChild(row);
    }

    function removeFaq(button) {
        const row = button.closest('.faq-row');
        if (row) row.remove();
        reindexFaqs();
    }

    function updateDiscount() {
        const original = parseFloat(document.querySelector('input[name="original_price"]')?.value || '0');
        const sale = parseFloat(document.querySelector('input[name="price"]')?.value || '0');
        const discountInput = document.querySelector('input[name="discount"]');
        if (!discountInput) return;

        if (original > 0 && sale > original) {
            discountInput.value = '0.00';
            return;
        }

        const discount = Math.max(original - sale, 0);
        discountInput.value = discount.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('input[name="original_price"]')?.addEventListener('input', updateDiscount);
        document.querySelector('input[name="price"]')?.addEventListener('input', updateDiscount);
        updateDiscount();
        reindexFaqs();
    });
</script>
@endpush
