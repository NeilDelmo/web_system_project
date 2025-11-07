<?php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class BrevoTransportServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Leave this empty (or register your own bindings if needed)
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory())->create(
                new Dsn('brevo+api', 'default', config('services.brevo.key'))
            );
        });
    }
}