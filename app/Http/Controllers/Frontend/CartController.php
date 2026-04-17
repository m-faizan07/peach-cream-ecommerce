<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function resolveProduct(): array
    {
        $product = Product::first();

        if ($product) {
            return [
                'id' => $product->id,
                'quantity' => max((int) $product->quantity, 0),
                'price' => (float) $product->price,
                'discount' => (float) $product->discount,
            ];
        }

        // Static fallback values matching current frontend presentation.
        return ['id' => 1, 'quantity' => 99, 'price' => 60.0, 'discount' => 10.0];
    }

    public function index()
    {
        $product = $this->resolveProduct();
        $cart = session('cart', []);

        $qty = $cart[$product['id']]['quantity'] ?? 0;
        if ($qty < 1) {
            return view('frontend.empty-cart');
        }
        $unit = max($product['price'] - $product['discount'], 0);
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
