<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Authentic extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('emails.contact.auth')
                    ->with(['token' => $this->token]);
    }}
