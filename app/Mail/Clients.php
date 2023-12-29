<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RegisterCompany;

class Clients extends Mailable
{
    use Queueable, SerializesModels;

    public $regis;
    public function __construct(RegisterCompany $hey)
    {
        $this->regis = $hey;
    }

    public function build()
    {
        return $this->markdown('emails.client.clients')
                    ->with(['r' => $this->regis]);
    }

}
