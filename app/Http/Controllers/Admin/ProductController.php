<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin-backend.products-index', compact('products'));
    }

    public function create()
    {
        $product = new Product([
            'title' => '',
            'tagline' => '',
            'description' => '',
            'quantity' => 0,
            'price' => 50,
            'original_price' => 60,
            'discount' => 10,
            'review_count' => 243,
            'badges_json' => [],
            'gallery_images_json' => [],
            'tabs_json' => [],
        ]);

        return view('admin-backend.products-form', [
            'product' => $product,
            'isEdit' => false,
            'badges' => [],
            'galleryImages' => [],
            'faqs' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        $product = new Product($data);
        if ($request->hasFile('main_image')) {
            $product->main_image = $request->file('main_image')->store('products', 'public');
        }
        $product->save();

        if ($request->hasFile('gallery_images')) {
            foreach ((array) $request->file('gallery_images') as $imageFile) {
                if (! $imageFile) {
                    continue;
                }
                $path = $imageFile->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin-backend.products-form', [
            'product' => $product,
            'isEdit' => true,
            'badges' => $product->badges_json ?? [],
            'galleryImages' => $product->images,
            'faqs' => $product->tabs_json ?? [],
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);

        if ($request->hasFile('gallery_images')) {
            foreach ((array) $request->file('gallery_images') as $imageFile) {
                if (! $imageFile) {
                    continue;
                }
                $path = $imageFile->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function deleteGalleryImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $image->delete();
        return back()->with('status', 'Gallery image removed.');
    }

    public function removeMainImage(Product $product)
    {
        $product->update(['main_image' => null]);
        return back()->with('status', 'Main image removed.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'review_count' => ['nullable', 'integer', 'min:0'],
            'main_image' => ['nullable', 'image', 'max:2048'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['nullable', 'image', 'max:4096'],
            'badges' => ['nullable', 'array'],
            'badges.*' => ['nullable', 'string', 'max:255'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.title' => ['nullable', 'string', 'max:255'],
            'faqs.*.content' => ['nullable', 'string'],
        ]);

        $originalPrice = (float) ($data['original_price'] ?? 0);
        $salePrice = (float) $data['price'];
        if ($originalPrice > 0 && $salePrice > $originalPrice) {
            throw ValidationException::withMessages([
                'price' => 'Sale price cannot be greater than original price.',
            ]);
        }

        $data['discount'] = max($originalPrice - $salePrice, 0);

        $badges = array_values(array_filter(array_map('trim', (array) ($request->input('badges', []))), fn ($badge) => $badge !== ''));
        $existingGallery = array_values(array_filter(array_map('trim', (array) ($request->input('existing_gallery_images', []))), fn ($img) => $img !== ''));
        $faqs = [];
        foreach ((array) $request->input('faqs', []) as $faq) {
            $title = trim((string) ($faq['title'] ?? ''));
            $content = trim((string) ($faq['content'] ?? ''));
            if ($title === '' && $content === '') {
                continue;
            }
            $faqs[] = ['title' => $title, 'content' => $content];
        }

        $data['badges_json'] = $badges;
        $data['gallery_images_json'] = $existingGallery;
        $data['tabs_json'] = $faqs;
        $data['review_count'] = $data['review_count'] ?? 0;
        $data['original_price'] = $data['original_price'] ?? null;

        return $data;
    }
}
