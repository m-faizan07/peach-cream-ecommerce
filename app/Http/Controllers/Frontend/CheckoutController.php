<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private function resolveProduct(): array
    {
        $product = Product::first();

        if ($product) {
            return [
                'model' => $product,
                'id' => $product->id,
                'price' => (float) $product->price,
                'discount' => (float) $product->discount,
            ];
        }

        return [
            'model' => null,
            'id' => 1,
            'price' => 60.0,
            'discount' => 10.0,
        ];
    }

    public function shippingInfo(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'email' => ['required', 'email'],
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'address' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:100'],
                'state' => ['required', 'string', 'max:100'],
                'zipcode' => ['required', 'string', 'max:20'],
                'mobile' => ['required', 'string', 'max:50'],
                'shipping_country' => ['nullable', 'string', 'max:100'],
            ]);

            $checkout = session('checkout', []);
            $checkout['email'] = (string) $data['email'];
            $checkout['phone'] = (string) $data['mobile'];
            $checkout['shipping_name'] = trim((string) $data['first_name'] . ' ' . (string) $data['last_name']);
            $checkout['shipping_line1'] = (string) $data['address'];
            $checkout['shipping_city'] = (string) $data['city'];
            $checkout['shipping_state'] = (string) $data['state'];
            $checkout['shipping_zipcode'] = (string) $data['zipcode'];
            $checkout['shipping_country'] = (string) ($data['shipping_country'] ?? 'United States');
            $checkout['billing_name'] = $checkout['shipping_name'];
            $checkout['billing_line1'] = $checkout['shipping_line1'];
            $checkout['billing_city'] = $checkout['shipping_city'];
            $checkout['billing_state'] = $checkout['shipping_state'];
            $checkout['billing_zipcode'] = $checkout['shipping_zipcode'];
            $checkout['billing_country'] = $checkout['shipping_country'];
            session(['checkout' => $checkout]);

            return redirect()->route('frontend.checkout-shipping');
        }

        $product = $this->resolveProduct();
        $qty = session('cart.' . $product['id'] . '.quantity', 0);
        $unit = max($product['price'] - $product['discount'], 0);
        $subtotal = $unit * $qty;
        $checkout = session('checkout', []);
        return view('frontend.shipping', compact('product', 'qty', 'unit', 'subtotal', 'checkout'));
    }

    public function saveShippingInfo(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_line1' => ['required', 'string', 'max:255'],
            'shipping_city' => ['required', 'string', 'max:100'],
            'shipping_country' => ['required', 'string', 'max:100'],
            'billing_name' => ['nullable', 'string', 'max:255'],
            'billing_line1' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['nullable', 'string', 'max:100'],
            'billing_country' => ['nullable', 'string', 'max:100'],
        ]);

        $data['billing_name'] = $data['billing_name'] ?: $data['shipping_name'];
        $data['billing_line1'] = $data['billing_line1'] ?: $data['shipping_line1'];
        $data['billing_city'] = $data['billing_city'] ?: $data['shipping_city'];
        $data['billing_country'] = $data['billing_country'] ?: $data['shipping_country'];

        session(['checkout' => array_merge(session('checkout', []), $data)]);
        return redirect()->route('frontend.checkout-shipping');
    }

    public function shippingMethod(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'shipping_method' => ['required', 'in:free,paid,priority'],
            ]);

            $checkout = session('checkout', []);
            $selectedMethod = $data['shipping_method'];
            $checkout['shipping_method'] = $selectedMethod === 'priority' ? 'paid' : $selectedMethod;
            session(['checkout' => $checkout]);

            return redirect()->route('frontend.payment');
        }

        $product = $this->resolveProduct();
        $qty = session('cart.' . $product['id'] . '.quantity', 0);
        $unit = max($product['price'] - $product['discount'], 0);
        $subtotal = $unit * $qty;
        $checkout = session('checkout', []);
        $shippingMethod = $checkout['shipping_method'] ?? 'free';
        $shippingCost = $shippingMethod === 'paid' ? 10 : 0;

        return view('frontend.checkout-shipping', compact('product', 'qty', 'unit', 'subtotal', 'checkout', 'shippingMethod', 'shippingCost'));
    }

    public function saveShippingMethod(Request $request)
    {
        $data = $request->validate([
            'shipping_method' => ['required', 'in:free,paid'],
        ]);

        session(['checkout' => array_merge(session('checkout', []), $data)]);
        return redirect()->route('frontend.payment');
    }

    public function payment(Request $request)
    {
        if ($request->filled('shipping_method')) {
            $checkout = session('checkout', []);
            $checkout['shipping_method'] = $request->input('shipping_method');
            session(['checkout' => $checkout]);
        }

        $product = $this->resolveProduct();
        $qty = session('cart.' . $product['id'] . '.quantity', 0);
        $unit = max($product['price'] - $product['discount'], 0);
        $subtotal = $unit * $qty;
        $checkout = session('checkout', []);
        $shippingMethod = $checkout['shipping_method'] ?? 'free';
        $shippingCost = $shippingMethod === 'paid' ? 10 : 0;

        return view('frontend.payment', compact('product', 'qty', 'unit', 'subtotal', 'checkout', 'shippingCost'));
    }

    public function place(Request $request)
    {
        if ($request->filled('payment_method')) {
            $checkout = session('checkout', []);
            $checkout['payment_method'] = $request->input('payment_method');
            session(['checkout' => $checkout]);
        }

        $product = $this->resolveProduct();
        $qty = session('cart.' . $product['id'] . '.quantity', 0);
        abort_if($qty < 1, 422, 'Cart is empty.');

        $paymentMethod = $request->input('payment_method', session('checkout.payment_method', 'credit_card'));
        if (! in_array($paymentMethod, ['credit_card', 'paypal'], true)) {
            $paymentMethod = 'credit_card';
        }
        $data = ['payment_method' => $paymentMethod];
        $checkout = session('checkout', []);

        $required = [
            'email', 'shipping_name', 'shipping_line1', 'shipping_city', 'shipping_country',
            'billing_name', 'billing_line1', 'billing_city', 'billing_country', 'shipping_method',
        ];
        foreach ($required as $field) {
            abort_unless(isset($checkout[$field]) && $checkout[$field] !== '', 422, 'Checkout information incomplete.');
        }

        $unit = max($product['price'] - $product['discount'], 0);
        $subtotal = $unit * $qty;
        $shippingCost = $checkout['shipping_method'] === 'paid' ? 10 : 0;

        DB::transaction(function () use ($product, $qty, $data, $checkout, $subtotal, $shippingCost) {
            $order = Order::create([
                'email' => $checkout['email'],
                'phone' => $checkout['phone'] ?? null,
                'shipping_address' => [
                    'name' => $checkout['shipping_name'],
                    'line1' => $checkout['shipping_line1'],
                    'city' => $checkout['shipping_city'],
                    'state' => $checkout['shipping_state'] ?? null,
                    'zipcode' => $checkout['shipping_zipcode'] ?? null,
                    'country' => $checkout['shipping_country'],
                ],
                'billing_address' => [
                    'name' => $checkout['billing_name'],
                    'line1' => $checkout['billing_line1'],
                    'city' => $checkout['billing_city'],
                    'state' => $checkout['billing_state'] ?? null,
                    'zipcode' => $checkout['billing_zipcode'] ?? null,
                    'country' => $checkout['billing_country'],
                ],
                'shipping_method' => $checkout['shipping_method'],
                'shipping_cost' => $shippingCost,
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'total' => $subtotal + $shippingCost,
            ]);

            if ($product['model']) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product['model']->id,
                    'quantity' => $qty,
                    'price' => $product['model']->price,
                    'discount' => $product['model']->discount,
                    'line_total' => $subtotal,
                ]);

                $product['model']->decrement('quantity', $qty);
            }
        });

        session()->forget(['cart', 'checkout']);
        return redirect()->route('frontend.product')->with('status', 'Order placed successfully.');
    }
}
