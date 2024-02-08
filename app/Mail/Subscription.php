<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CompanyToken;

class Subscription extends Mailable
{
    use Queueable, SerializesModels;

   public $company;
    public function __construct(CompanyToken $companyToken)
    {
      $this->company = $companyToken;
    }

    public function build(){
        return $this->markdown("emails.client.subscription")
        ->with(["company" => $this->company]);
    }

   }
