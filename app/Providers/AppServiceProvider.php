<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\Mailer\Transport;

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
