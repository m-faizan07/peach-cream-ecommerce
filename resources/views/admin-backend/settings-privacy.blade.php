@extends('admin-backend.main.panel')
@section('title', 'Settings & Privacy')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Settings & Privacy</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.privacy.update') }}" class="row g-3">
            @csrf
            <div class="col-12">
                <h5 class="mb-1">Fallback Product Values</h5>
                <p class="text-muted mb-2">
                    Used only when no product exists in database.
                </p>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fallback Quantity</label>
                <input class="form-control" type="number" min="0" name="fallback_quantity" value="{{ old('fallback_quantity', $settings->fallback_quantity) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fallback Original Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="fallback_original_price" value="{{ old('fallback_original_price', $settings->fallback_original_price) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fallback Sale Price</label>
                <input class="form-control" type="number" step="0.01" min="0" name="fallback_sale_price" value="{{ old('fallback_sale_price', $settings->fallback_sale_price) }}" required>
            </div>

            <div class="col-12 mt-4">
                <h5 class="mb-1">PayPal (Mandatory for PayPal checkout)</h5>
            </div>
            <div class="col-md-4">
                <label class="form-label">PAYPAL_CLIENT_ID</label>
                <input class="form-control" name="paypal_client_id" value="{{ old('paypal_client_id', $settings->paypal_client_id) }}" placeholder="{{ env('PAYPAL_CLIENT_ID') ? 'Using saved value' : 'Fallback from .env if empty' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">PAYPAL_SECRET</label>
                <input class="form-control" name="paypal_secret" value="{{ old('paypal_secret', $settings->paypal_secret) }}" placeholder="{{ env('PAYPAL_SECRET') ? 'Using saved value' : 'Fallback from .env if empty' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">PAYPAL_MODE</label>
                <select class="form-control" name="paypal_mode">
                    @php $paypalMode = old('paypal_mode', $settings->paypal_mode ?: env('PAYPAL_MODE', 'sandbox')); @endphp
                    <option value="">Use .env</option>
                    <option value="sandbox" {{ $paypalMode === 'sandbox' ? 'selected' : '' }}>sandbox</option>
                    <option value="live" {{ $paypalMode === 'live' ? 'selected' : '' }}>live</option>
                </select>
            </div>

            <div class="col-12 mt-4">
                <h5 class="mb-1">Pusher (Optional)</h5>
            </div>
            <div class="col-md-3">
                <label class="form-label">PUSHER_APP_ID</label>
                <input class="form-control" name="pusher_app_id" value="{{ old('pusher_app_id', $settings->pusher_app_id) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">PUSHER_APP_KEY</label>
                <input class="form-control" name="pusher_app_key" value="{{ old('pusher_app_key', $settings->pusher_app_key) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">PUSHER_APP_SECRET</label>
                <input class="form-control" name="pusher_app_secret" value="{{ old('pusher_app_secret', $settings->pusher_app_secret) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">PUSHER_APP_CLUSTER</label>
                <input class="form-control" name="pusher_app_cluster" value="{{ old('pusher_app_cluster', $settings->pusher_app_cluster) }}">
            </div>

            <div class="col-12 mt-4">
                <h5 class="mb-1">Mail SMTP (Optional)</h5>
            </div>
            <div class="col-md-3">
                <label class="form-label">MAIL_MAILER</label>
                <input class="form-control" name="mail_mailer" value="{{ old('mail_mailer', $settings->mail_mailer) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">MAIL_HOST</label>
                <input class="form-control" name="mail_host" value="{{ old('mail_host', $settings->mail_host) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">MAIL_PORT</label>
                <input class="form-control" type="number" min="1" name="mail_port" value="{{ old('mail_port', $settings->mail_port) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">MAIL_USERNAME</label>
                <input class="form-control" name="mail_username" value="{{ old('mail_username', $settings->mail_username) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">MAIL_PASSWORD</label>
                <input class="form-control" name="mail_password" value="{{ old('mail_password', $settings->mail_password) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">MAIL_ENCRYPTION</label>
                <input class="form-control" name="mail_encryption" value="{{ old('mail_encryption', $settings->mail_encryption) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">MAIL_FROM_ADDRESS</label>
                <input class="form-control" name="mail_from_address" value="{{ old('mail_from_address', $settings->mail_from_address) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">MAIL_FROM_NAME</label>
                <input class="form-control" name="mail_from_name" value="{{ old('mail_from_name', $settings->mail_from_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">ADMIN_NOTIFICATION_EMAIL</label>
                <input class="form-control" name="admin_notification_email" value="{{ old('admin_notification_email', $settings->admin_notification_email) }}">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
