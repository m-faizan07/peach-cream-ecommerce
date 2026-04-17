<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string'],
        ]);

        $fullName = trim((string) $data['first_name'] . ' ' . (string) ($data['last_name'] ?? ''));
        $subject = 'Website Contact Form';
        $phone = trim((string) ($data['phone'] ?? ''));
        $messageBody = (string) $data['message'];

        ContactInquiry::create([
            'name' => $fullName !== '' ? $fullName : (string) $data['first_name'],
            'email' => (string) $data['email'],
            'subject' => $subject,
            'message' => $messageBody,
        ]);

        $adminEmail = (string) config('mail.admin_address', config('mail.from.address'));
        if ($adminEmail !== '') {
            Mail::send('emails.contact-inquiry', [
                'name' => $fullName !== '' ? $fullName : 'N/A',
                'email' => (string) $data['email'],
                'phone' => $phone !== '' ? $phone : 'N/A',
                'messageText' => $messageBody,
            ], function ($message) use ($adminEmail, $subject, $fullName, $data) {
                $nameLine = $fullName !== '' ? $fullName : 'N/A';
                $message->to($adminEmail)
                    ->replyTo((string) $data['email'], $nameLine)
                    ->subject($subject);
            });
        }

        return back()->with('status', 'Message sent.');
    }
}
