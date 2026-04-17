<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function product()
    {
        $product = Product::with('images')->latest()->first();

        $defaults = [
            'title' => 'Peach Cream',
            'tagline' => 'A skincare-first approach to comfort, hydration, and barrier support. No steroids. No numbing. Just happy skin.',
            'description' => 'Peach Cream is a daily perianal skincare cream - not a drug, just clean, clinical-grade care.',
            'price' => 50.00,
            'original_price' => 60.00,
            'review_count' => 243,
            'rating_value' => 5.0,
            'main_image' => 'images/what-make-you-happy.png',
            'gallery_images' => [
                'images/what-make-you-happy.png',
                'images/hero-img.png',
                'images/readytogive.png',
                'images/daily-care.jpg',
            ],
            'badges' => [
                'pH-balanced & Fragrance free',
                'No steroids / no numbing agents',
                'Dermatologist reviewed',
                'Ships worldwide',
            ],
            'tabs' => [
                ['title' => 'Description', 'content' => 'Peach Cream is a daily perianal skincare cream - not a drug, just clean, clinical-grade care.'],
                ['title' => 'How To Use', 'content' => 'Cleanse gently, apply pea-sized amount, and use once or twice daily.'],
                ['title' => 'Price Breakdown', 'content' => 'Regular Price: $60.00, Sale Price: $50.00, You Save: $10.00'],
                ['title' => 'Ingredients', 'content' => 'Water, Glycerin, Ceramide NP, Panthenol, Allantoin, Bisabolol, Betaine.'],
                ['title' => 'Shipping & Delivery', 'content' => 'Standard Shipping: 5-7 business days, Express Shipping: 2-3 business days.'],
            ],
        ];

        $viewData = [
            'title' => $product->title ?? $defaults['title'],
            'tagline' => $product->tagline ?? $defaults['tagline'],
            'description' => $product->description ?? $defaults['description'],
            'price' => $product->price ?? $defaults['price'],
            'original_price' => $product->original_price ?? $defaults['original_price'],
            'review_count' => $product->review_count ?? $defaults['review_count'],
            'rating_value' => $product->rating_value ?? $defaults['rating_value'],
            'main_image' => ($product && $product->main_image)
                ? $this->resolveImageUrl($product->main_image, $defaults['main_image'])
                : asset('frontend/' . $defaults['main_image']),
            'gallery_images' => collect($product ? $product->images->pluck('image_path')->all() : [])
                ->filter()
                ->map(fn ($img) => $this->resolveImageUrl($img))
                ->filter()
                ->values()
                ->all(),
            'badges' => ($product && !empty($product->badges_json)) ? $product->badges_json : $defaults['badges'],
            'tabs' => ($product && !empty($product->tabs_json)) ? $product->tabs_json : $defaults['tabs'],
            'in_stock' => $product ? ((int) $product->quantity > 0) : true,
        ];

        if (empty($viewData['gallery_images'])) {
            $viewData['gallery_images'] = collect($defaults['gallery_images'])
                ->map(fn ($img) => asset('frontend/' . ltrim($img, '/')))
                ->all();
        }

        return view('frontend.Product-page', $viewData);
    }

    private function resolveImageUrl(string $path, ?string $fallback = null): ?string
    {
        $path = ltrim($path, '/');

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        if (str_starts_with($path, 'images/')) {
            return asset('frontend/' . $path);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if ($fallback !== null) {
            return asset('frontend/' . ltrim($fallback, '/'));
        }

        return null;
    }

    public function storeReview(Request $request)
    {
        $product = Product::first();
        if (! $product) {
            return back()->with('status', 'Review received.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string'],
        ]);

        Review::create($data + ['product_id' => $product->id, 'status' => 'pending']);
        return back()->with('status', 'Review submitted for approval.');
    }
}
