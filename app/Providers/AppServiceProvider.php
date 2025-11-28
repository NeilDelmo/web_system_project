<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\Mailer\Transport;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if (Schema::hasTable('system_settings')) {
            // Load Email Settings
            $mailSettings = [
                'mail_mailer' => SystemSetting::get('mail_mailer'),
                'mail_host' => SystemSetting::get('mail_host'),
                'mail_port' => SystemSetting::get('mail_port'),
                'mail_username' => SystemSetting::get('mail_username'),
                'mail_password' => SystemSetting::get('mail_password'),
                'mail_encryption' => SystemSetting::get('mail_encryption'),
                'mail_from_address' => SystemSetting::get('mail_from_address'),
                'mail_from_name' => SystemSetting::get('mail_from_name'),
            ];

            if ($mailSettings['mail_host']) {
                Config::set('mail.mailers.smtp.host', $mailSettings['mail_host']);
                Config::set('mail.mailers.smtp.port', $mailSettings['mail_port']);
                Config::set('mail.mailers.smtp.username', $mailSettings['mail_username']);
                Config::set('mail.mailers.smtp.password', $mailSettings['mail_password']);
                Config::set('mail.mailers.smtp.encryption', $mailSettings['mail_encryption']);
                Config::set('mail.from.address', $mailSettings['mail_from_address']);
                Config::set('mail.from.name', $mailSettings['mail_from_name']);
            }

            // Share Bakery Info with all views
            $bakeryInfo = [
                'name' => SystemSetting::get('bakery_name', 'Cuevas Bakery'),
                'address' => SystemSetting::get('bakery_address'),
                'phone' => SystemSetting::get('bakery_phone'),
                'email' => SystemSetting::get('bakery_email'),
            ];
            View::share('bakeryInfo', $bakeryInfo);
        }

        Mail::extend('brevo', function (array $config) {
            $dsn = $config['dsn'] ?? null;

            if (! $dsn) {
                throw new InvalidArgumentException('Brevo DSN is not configured.');
            }

            // Use Symfony Mailer factory so we can leverage Brevo API transport.
            return Transport::fromDsn($dsn);
        });
    }
}
