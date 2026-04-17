<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    private function resolveProduct(): array
    {
        $product = Product::latest()->first();

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
            'price' => 50.0,
            'discount' => 10.0,
        ];
    }

    public function shippingInfo(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'email' => ['required', 'email'],
                'newsletter_opt_in' => ['nullable', 'boolean'],
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
            $checkout['newsletter_opt_in'] = (bool) ($data['newsletter_opt_in'] ?? false);

            if ($checkout['newsletter_opt_in']) {
                NewsletterSubscription::firstOrCreate([
                    'email' => (string) $data['email'],
                ]);
            }

            session(['checkout' => $checkout]);

            return redirect()->route('frontend.checkout-shipping');
        }

        $product = $this->resolveProduct();
        $qty = session('cart.' . $product['id'] . '.quantity', 0);
        $unit = max($product['price'], 0);
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
        $unit = max($product['price'], 0);
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
        $unit = max($product['price'], 0);
        $subtotal = $unit * $qty;
        $checkout = session('checkout', []);
        $shippingMethod = $checkout['shipping_method'] ?? 'free';
        $shippingCost = $shippingMethod === 'paid' ? 10 : 0;

        $stripePublicKey = (string) config('services.stripe.public');

        return view('frontend.payment', compact('product', 'qty', 'unit', 'subtotal', 'checkout', 'shippingCost', 'stripePublicKey'));
    }

    public function place(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:credit_card,paypal'],
            'stripe_payment_intent_id' => ['nullable', 'string'],
        ]);

        $checkout = session('checkout', []);
        $checkout['payment_method'] = $data['payment_method'];
        session(['checkout' => $checkout]);

        $summary = $this->validateCheckoutAndGetSummary();

        if ($data['payment_method'] === 'paypal') {
            return $this->startPaypalCheckout($summary['total']);
        }

        $paymentIntentId = (string) ($data['stripe_payment_intent_id'] ?? '');
        if ($paymentIntentId === '') {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Card payment authorization missing.']);
        }

        $secret = (string) config('services.stripe.secret');
        if ($secret === '') {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Stripe is not configured yet.']);
        }

        $verifyResponse = Http::withToken($secret)->get("https://api.stripe.com/v1/payment_intents/{$paymentIntentId}");
        if (! $verifyResponse->successful()) {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Unable to verify Stripe payment.']);
        }

        $intent = $verifyResponse->json();
        if (($intent['status'] ?? null) !== 'succeeded') {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Stripe payment not completed.']);
        }

        $this->createOrderFromSession('credit_card', 'stripe', $paymentIntentId, 'paid');
        return redirect()->route('frontend.home')->with('status', 'Payment successful. Order placed.');
    }

    public function createStripeIntent(Request $request): JsonResponse
    {
        $secret = (string) config('services.stripe.secret');
        if ($secret === '') {
            return response()->json(['message' => 'Stripe is not configured yet.'], 422);
        }

        $summary = $this->validateCheckoutAndGetSummary();
        $amountInCents = (int) round($summary['total'] * 100);
        if ($amountInCents < 50) {
            return response()->json(['message' => 'Invalid payment amount.'], 422);
        }

        $response = Http::withToken($secret)
            ->asForm()
            ->post('https://api.stripe.com/v1/payment_intents', [
                'amount' => $amountInCents,
                'currency' => 'usd',
                'automatic_payment_methods[enabled]' => 'false',
                'payment_method_types[]' => 'card',
                'metadata[checkout_source]' => 'peach-cream',
            ]);

        if (! $response->successful()) {
            return response()->json(['message' => 'Unable to initialize Stripe payment.'], 422);
        }

        return response()->json([
            'client_secret' => $response->json('client_secret'),
        ]);
    }

    public function stripeSuccess(Request $request): RedirectResponse
    {
        $sessionId = (string) $request->query('session_id', '');
        abort_if($sessionId === '', 422, 'Missing Stripe session id.');

        $secret = (string) config('services.stripe.secret');
        abort_if($secret === '', 500, 'Stripe secret key not configured.');

        $response = Http::withToken($secret)
            ->get("https://api.stripe.com/v1/checkout/sessions/{$sessionId}");

        abort_unless($response->successful(), 422, 'Stripe verification failed.');

        $payload = $response->json();
        abort_unless(($payload['payment_status'] ?? null) === 'paid', 422, 'Stripe payment not completed.');

        $this->createOrderFromSession('credit_card', 'stripe', $sessionId, 'paid');

        return redirect()->route('frontend.home')->with('status', 'Payment successful. Order placed.');
    }

    public function stripeCancel(): RedirectResponse
    {
        return redirect()->route('frontend.payment')->withErrors(['payment' => 'Stripe payment was canceled.']);
    }

    public function paypalSuccess(Request $request): RedirectResponse
    {
        $paypalOrderId = (string) $request->query('token', '');
        abort_if($paypalOrderId === '', 422, 'Missing PayPal token.');

        $accessToken = $this->getPaypalAccessToken();
        abort_if($accessToken === '', 500, 'PayPal API credentials are not configured.');

        $baseUrl = $this->paypalBaseUrl();
        $captureResponse = Http::withToken($accessToken)->post("{$baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");
        abort_unless($captureResponse->successful(), 422, 'PayPal capture failed.');

        $payload = $captureResponse->json();
        abort_unless(($payload['status'] ?? null) === 'COMPLETED', 422, 'PayPal payment not completed.');

        $this->createOrderFromSession('paypal', 'paypal', $paypalOrderId, 'paid');

        return redirect()->route('frontend.home')->with('status', 'Payment successful. Order placed.');
    }

    public function paypalCancel(): RedirectResponse
    {
        return redirect()->route('frontend.payment')->withErrors(['payment' => 'PayPal payment was canceled.']);
    }

    private function validateCheckoutAndGetSummary(): array
    {
        $product = $this->resolveProduct();
        $qty = (int) session('cart.' . $product['id'] . '.quantity', 0);
        abort_if($qty < 1, 422, 'Cart is empty.');

        $checkout = session('checkout', []);
        $required = [
            'email', 'shipping_name', 'shipping_line1', 'shipping_city', 'shipping_country',
            'billing_name', 'billing_line1', 'billing_city', 'billing_country', 'shipping_method',
        ];
        foreach ($required as $field) {
            abort_unless(isset($checkout[$field]) && $checkout[$field] !== '', 422, 'Checkout information incomplete.');
        }

        $unit = max($product['price'], 0);
        $subtotal = $unit * $qty;
        $shippingCost = ($checkout['shipping_method'] ?? 'free') === 'paid' ? 10 : 0;

        return [
            'product' => $product,
            'checkout' => $checkout,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal + $shippingCost,
        ];
    }

    private function startStripeCheckout(float $total): RedirectResponse
    {
        $secret = (string) config('services.stripe.secret');
        if ($secret === '') {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Stripe is not configured yet.']);
        }

        $successUrl = route('frontend.payment.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('frontend.payment.stripe.cancel');

        $response = Http::withToken($secret)
            ->asForm()
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'line_items[0][price_data][currency]' => 'usd',
                'line_items[0][price_data][product_data][name]' => 'Peach Cream Order',
                'line_items[0][price_data][unit_amount]' => (int) round($total * 100),
                'line_items[0][quantity]' => 1,
            ]);

        if (! $response->successful() || empty($response->json('url'))) {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Unable to start Stripe checkout.']);
        }

        return redirect()->away($response->json('url'));
    }

    private function startPaypalCheckout(float $total): RedirectResponse
    {
        $accessToken = $this->getPaypalAccessToken();
        if ($accessToken === '') {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'PayPal is not configured yet.']);
        }

        $baseUrl = $this->paypalBaseUrl();
        $response = Http::withToken($accessToken)->post("{$baseUrl}/v2/checkout/orders", [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($total, 2, '.', ''),
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => route('frontend.payment.paypal.success'),
                'cancel_url' => route('frontend.payment.paypal.cancel'),
            ],
        ]);

        if (! $response->successful()) {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'Unable to start PayPal checkout.']);
        }

        $approveUrl = collect($response->json('links', []))->firstWhere('rel', 'approve')['href'] ?? null;
        if (! $approveUrl) {
            return redirect()->route('frontend.payment')->withErrors(['payment' => 'PayPal approval link missing.']);
        }

        return redirect()->away($approveUrl);
    }

    private function getPaypalAccessToken(): string
    {
        $clientId = (string) config('services.paypal.client_id');
        $secret = (string) config('services.paypal.secret');
        if ($clientId === '' || $secret === '') {
            return '';
        }

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post($this->paypalBaseUrl() . '/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            return '';
        }

        return (string) $response->json('access_token', '');
    }

    private function paypalBaseUrl(): string
    {
        return config('services.paypal.mode') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    private function createOrderFromSession(string $paymentMethod, string $provider, string $reference, string $status): Order
    {
        $existing = Order::where('payment_provider', $provider)
            ->where('payment_reference', $reference)
            ->first();
        if ($existing) {
            session()->forget(['cart', 'checkout']);
            return $existing;
        }

        $summary = $this->validateCheckoutAndGetSummary();
        $product = $summary['product'];
        $checkout = $summary['checkout'];
        $qty = $summary['qty'];
        $subtotal = $summary['subtotal'];
        $shippingCost = $summary['shipping_cost'];

        $order = DB::transaction(function () use ($product, $checkout, $qty, $subtotal, $shippingCost, $paymentMethod, $provider, $reference, $status) {
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
                'payment_method' => $paymentMethod,
                'payment_provider' => $provider,
                'payment_reference' => $reference,
                'subtotal' => $subtotal,
                'total' => $subtotal + $shippingCost,
                'status' => $status,
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

            return $order;
        });

        session()->forget(['cart', 'checkout']);
        return $order;
    }
}
