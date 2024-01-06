<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CompanySetUp;


class Setup extends Mailable
{
    use Queueable, SerializesModels;


    public $SetUp;
    public function __construct(CompanySetUp $setUp)
    {
        $this->SetUp = $setUp;
    }

    public function build(){
        return $this->markdown("emails.clients.setup")
        ->with(["setUp"=>$this->SetUp])
        ;
    }




   }
