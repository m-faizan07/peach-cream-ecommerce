<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class PublicFormController extends Controller
{
    public function newsletter(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
        NewsletterSubscription::firstOrCreate(['email' => $request->email]);
        return back()->with('status', 'Subscribed successfully.');
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);
        ContactInquiry::create($data);
        return back()->with('status', 'Message sent.');
    }
}
