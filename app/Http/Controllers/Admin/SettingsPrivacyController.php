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
            'paypal_client_id' => ['nullable', 'string', 'max:255'],
            'paypal_secret' => ['nullable', 'string', 'max:255'],
            'paypal_mode' => ['nullable', 'in:live,sandbox'],
            'pusher_app_id' => ['nullable', 'string', 'max:255'],
            'pusher_app_key' => ['nullable', 'string', 'max:255'],
            'pusher_app_secret' => ['nullable', 'string', 'max:255'],
            'pusher_app_cluster' => ['nullable', 'string', 'max:255'],
            'mail_mailer' => ['nullable', 'string', 'max:255'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer', 'min:1'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'max:255'],
            'mail_from_address' => ['nullable', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
            'admin_notification_email' => ['nullable', 'email', 'max:255'],
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
            'paypal_client_id' => $this->nullIfEmpty($data['paypal_client_id'] ?? null),
            'paypal_secret' => $this->nullIfEmpty($data['paypal_secret'] ?? null),
            'paypal_mode' => $this->nullIfEmpty($data['paypal_mode'] ?? null),
            'pusher_app_id' => $this->nullIfEmpty($data['pusher_app_id'] ?? null),
            'pusher_app_key' => $this->nullIfEmpty($data['pusher_app_key'] ?? null),
            'pusher_app_secret' => $this->nullIfEmpty($data['pusher_app_secret'] ?? null),
            'pusher_app_cluster' => $this->nullIfEmpty($data['pusher_app_cluster'] ?? null),
            'mail_mailer' => $this->nullIfEmpty($data['mail_mailer'] ?? null),
            'mail_host' => $this->nullIfEmpty($data['mail_host'] ?? null),
            'mail_port' => ! empty($data['mail_port']) ? (int) $data['mail_port'] : null,
            'mail_username' => $this->nullIfEmpty($data['mail_username'] ?? null),
            'mail_password' => $this->nullIfEmpty($data['mail_password'] ?? null),
            'mail_encryption' => $this->nullIfEmpty($data['mail_encryption'] ?? null),
            'mail_from_address' => $this->nullIfEmpty($data['mail_from_address'] ?? null),
            'mail_from_name' => $this->nullIfEmpty($data['mail_from_name'] ?? null),
            'admin_notification_email' => $this->nullIfEmpty($data['admin_notification_email'] ?? null),
        ]);

        return back()->with('status', 'Settings updated successfully.');
    }

    private function nullIfEmpty($value): ?string
    {
        $value = is_string($value) ? trim($value) : $value;
        return $value === '' || $value === null ? null : (string) $value;
    }
}
