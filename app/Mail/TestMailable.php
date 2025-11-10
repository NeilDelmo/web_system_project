<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class TestMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function build(): self
    {
        return $this
            ->subject('Cuevas Bakery Mail Test')
            ->view('emails.test');
    }
}
