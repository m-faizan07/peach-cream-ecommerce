<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function product()
    {
        // Fallback-friendly: if product content is missing, the Blade static content remains visible.
        $product = Product::with(['images', 'accordions', 'approvedReviews'])->first();
        return view('frontend.Product-page', compact('product'));
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
