<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return;
            }

            $settings = SiteSetting::query()->first();
        } catch (Throwable $e) {
            return;
        }
        if (! $settings) {
            return;
        }

        $this->setIfPresent('services.paypal.client_id', $settings->paypal_client_id);
        $this->setIfPresent('services.paypal.secret', $settings->paypal_secret);
        $this->setIfPresent('services.paypal.mode', $settings->paypal_mode);

        $this->setIfPresent('broadcasting.connections.pusher.app_id', $settings->pusher_app_id);
        $this->setIfPresent('broadcasting.connections.pusher.key', $settings->pusher_app_key);
        $this->setIfPresent('broadcasting.connections.pusher.secret', $settings->pusher_app_secret);
        $this->setIfPresent('broadcasting.connections.pusher.options.cluster', $settings->pusher_app_cluster);

        $resolvedPusherKey = (string) config('broadcasting.connections.pusher.key', '');
        Config::set('broadcasting.default', $resolvedPusherKey !== '' ? 'pusher' : 'log');

        $this->setIfPresent('mail.default', $settings->mail_mailer);
        $this->setIfPresent('mail.mailers.smtp.host', $settings->mail_host);
        if (! empty($settings->mail_port)) {
            Config::set('mail.mailers.smtp.port', (int) $settings->mail_port);
        }
        $this->setIfPresent('mail.mailers.smtp.username', $settings->mail_username);
        $this->setIfPresent('mail.mailers.smtp.password', $settings->mail_password);
        $this->setIfPresent('mail.mailers.smtp.encryption', $settings->mail_encryption);
        $this->setIfPresent('mail.from.address', $settings->mail_from_address);
        $this->setIfPresent('mail.from.name', $settings->mail_from_name);
        $this->setIfPresent('mail.admin_address', $settings->admin_notification_email);
    }

    private function setIfPresent(string $key, $value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        Config::set($key, $value);
    }
}
