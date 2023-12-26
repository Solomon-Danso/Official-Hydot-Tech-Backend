<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contacts;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contacts $contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->markdown('emails.contact.message')
                    ->with(['contact' => $this->contact]);
    }
}
