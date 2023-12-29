<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\RegisterCompany;

class UpdateClients extends Mailable
{
    use Queueable, SerializesModels;

    public $updater;

    public function __construct(RegisterCompany $company){
        $this->updater = $company;
    }

    public function build(){
        return $this->markdown("emails.client.updateclients")->with(['r'=>$this->updater]);
    }

 
}
