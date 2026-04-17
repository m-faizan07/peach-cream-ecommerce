<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'fallback_quantity',
        'fallback_original_price',
        'fallback_sale_price',
        'paypal_client_id',
        'paypal_secret',
        'paypal_mode',
        'pusher_app_id',
        'pusher_app_key',
        'pusher_app_secret',
        'pusher_app_cluster',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'admin_notification_email',
    ];

    protected $casts = [
        'mail_port' => 'integer',
    ];
}
