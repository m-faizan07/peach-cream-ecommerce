<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;

class ContactController extends Controller
{
    public function index()
    {
        $inquiries = ContactInquiry::latest()->paginate(50);
        return view('admin-backend.contacts-index', compact('inquiries'));
    }
}
