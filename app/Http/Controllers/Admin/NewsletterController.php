<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscriptions = NewsletterSubscription::latest()->paginate(50);
        return view('admin-backend.newsletter-index', compact('subscriptions'));
    }
}
