<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('site_settings', 'paypal_client_id')) {
                $table->string('paypal_client_id')->nullable()->after('fallback_sale_price');
            }
            if (! Schema::hasColumn('site_settings', 'paypal_secret')) {
                $table->string('paypal_secret')->nullable()->after('paypal_client_id');
            }
            if (! Schema::hasColumn('site_settings', 'paypal_mode')) {
                $table->string('paypal_mode')->nullable()->after('paypal_secret');
            }
            if (! Schema::hasColumn('site_settings', 'pusher_app_id')) {
                $table->string('pusher_app_id')->nullable()->after('paypal_mode');
            }
            if (! Schema::hasColumn('site_settings', 'pusher_app_key')) {
                $table->string('pusher_app_key')->nullable()->after('pusher_app_id');
            }
            if (! Schema::hasColumn('site_settings', 'pusher_app_secret')) {
                $table->string('pusher_app_secret')->nullable()->after('pusher_app_key');
            }
            if (! Schema::hasColumn('site_settings', 'pusher_app_cluster')) {
                $table->string('pusher_app_cluster')->nullable()->after('pusher_app_secret');
            }
            if (! Schema::hasColumn('site_settings', 'mail_mailer')) {
                $table->string('mail_mailer')->nullable()->after('pusher_app_cluster');
            }
            if (! Schema::hasColumn('site_settings', 'mail_host')) {
                $table->string('mail_host')->nullable()->after('mail_mailer');
            }
            if (! Schema::hasColumn('site_settings', 'mail_port')) {
                $table->unsignedInteger('mail_port')->nullable()->after('mail_host');
            }
            if (! Schema::hasColumn('site_settings', 'mail_username')) {
                $table->string('mail_username')->nullable()->after('mail_port');
            }
            if (! Schema::hasColumn('site_settings', 'mail_password')) {
                $table->string('mail_password')->nullable()->after('mail_username');
            }
            if (! Schema::hasColumn('site_settings', 'mail_encryption')) {
                $table->string('mail_encryption')->nullable()->after('mail_password');
            }
            if (! Schema::hasColumn('site_settings', 'mail_from_address')) {
                $table->string('mail_from_address')->nullable()->after('mail_encryption');
            }
            if (! Schema::hasColumn('site_settings', 'mail_from_name')) {
                $table->string('mail_from_name')->nullable()->after('mail_from_address');
            }
            if (! Schema::hasColumn('site_settings', 'admin_notification_email')) {
                $table->string('admin_notification_email')->nullable()->after('mail_from_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $columns = [
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

            foreach ($columns as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
