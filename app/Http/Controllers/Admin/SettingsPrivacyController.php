<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SettingsPrivacyController extends Controller
{
    public function show()
    {
        $settings = SiteSetting::query()->firstOrCreate([], [
            'fallback_quantity' => 99,
            'fallback_original_price' => 60.00,
            'fallback_sale_price' => 50.00,
        ]);

        return view('admin-backend.settings-privacy', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'fallback_quantity' => ['required', 'integer', 'min:0'],
            'fallback_original_price' => ['required', 'numeric', 'min:0'],
            'fallback_sale_price' => ['required', 'numeric', 'min:0'],
        ]);

        if ((float) $data['fallback_sale_price'] > (float) $data['fallback_original_price']) {
            throw ValidationException::withMessages([
                'fallback_sale_price' => 'Sale price cannot be greater than original price.',
            ]);
        }

        $settings = SiteSetting::query()->firstOrCreate([], [
            'fallback_quantity' => 99,
            'fallback_original_price' => 60.00,
            'fallback_sale_price' => 50.00,
        ]);

        $settings->update([
            'fallback_quantity' => (int) $data['fallback_quantity'],
            'fallback_original_price' => (float) $data['fallback_original_price'],
            'fallback_sale_price' => (float) $data['fallback_sale_price'],
        ]);

        return back()->with('status', 'Settings updated successfully.');
    }
}
