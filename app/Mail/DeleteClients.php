<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RegisterCompany;

class DeleteClients extends Mailable
{
    use Queueable, SerializesModels;

  public $CompanyName;
    public function __construct(RegisterCompany $l)
    {
        $this->CompanyName = $l;
    }

    public function build(){
        return $this->markdown("emails.client.deleteclients")
        ->with(["CompanyName"=> $this->CompanyName]);
    }

  }
