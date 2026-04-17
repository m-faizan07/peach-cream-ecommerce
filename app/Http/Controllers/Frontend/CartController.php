<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function resolveProduct(): array
    {
        $product = Product::latest()->first();

        if ($product) {
            return [
                'id' => $product->id,
                'quantity' => max((int) $product->quantity, 0),
                'price' => (float) $product->price,
                'discount' => (float) $product->discount,
            ];
        }

        $settings = SiteSetting::query()->first();
        $fallbackQuantity = $settings ? (int) $settings->fallback_quantity : 99;
        $fallbackOriginal = $settings ? (float) $settings->fallback_original_price : 60.0;
        $fallbackSale = $settings ? (float) $settings->fallback_sale_price : 50.0;

        return [
            'id' => 1,
            'quantity' => max($fallbackQuantity, 0),
            'price' => max($fallbackSale, 0),
            'discount' => max($fallbackOriginal - $fallbackSale, 0),
        ];
    }

    public function index()
    {
        $product = $this->resolveProduct();
        $cart = session('cart', []);

        $qty = $cart[$product['id']]['quantity'] ?? 0;
        if ($qty < 1) {
            return view('frontend.empty-cart');
        }
        $unit = max($product['price'], 0);
        $subtotal = $qty * $unit;
        return view('frontend.cart', compact('product', 'qty', 'subtotal', 'unit'));
    }

    public function add(Request $request)
    {
        $product = $this->resolveProduct();
        if ($product['quantity'] < 1) {
            return back()->withErrors(['stock' => 'Cannot add to cart because product is out of stock.']);
        }

        $qty = max((int) $request->input('quantity', 1), 1);
        $cart = session('cart', []);
        $current = $cart[$product['id']]['quantity'] ?? 0;
        $newQty = min($current + $qty, $product['quantity']);
        if ($newQty < 1) {
            return back()->withErrors(['stock' => 'Cannot add to cart because product is out of stock.']);
        }
        $cart[$product['id']] = ['quantity' => $newQty];
        session(['cart' => $cart]);
        return redirect()->route('frontend.cart');
    }

    public function update(Request $request)
    {
        $product = $this->resolveProduct();
        $qty = max((int) $request->input('quantity', 1), 1);
        $cart = session('cart', []);
        $cart[$product['id']] = ['quantity' => min($qty, $product['quantity'])];
        session(['cart' => $cart]);
        return back();
    }

    public function clear()
    {
        session()->forget(['cart', 'checkout']);
        return redirect()->route('frontend.empty-cart');
    }
}
