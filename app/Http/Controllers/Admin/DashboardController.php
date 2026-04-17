<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use App\Models\Order;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin-backend.index', [
            'ordersCount' => Order::count(),
            'pendingReviews' => Review::where('status', 'pending')->count(),
            'newsletterCount' => NewsletterSubscription::count(),
        ]);
    }
}
