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

        try {
            if (Schema::hasTable('system_settings')) {
                // Share Bakery Info with all views
                $bakeryInfo = [
                    'name' => SystemSetting::get('bakery_name', 'Cuevas Bakery'),
                    'address' => SystemSetting::get('bakery_address'),
                    'phone' => SystemSetting::get('bakery_phone'),
                    'email' => SystemSetting::get('bakery_email'),
                ];
                View::share('bakeryInfo', $bakeryInfo);
            }
        } catch (\Exception $e) {
            // Database might not be available yet (e.g. during migration or initial setup)
            // Fallback for bakery info to prevent view errors
             $bakeryInfo = [
                'name' => 'Cuevas Bakery',
                'address' => '',
                'phone' => '',
                'email' => '',
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
