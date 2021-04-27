<?php

namespace App\Mail;

use App\Models\Estimate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EstimateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $estimate;
    public $company_details;

    public function __construct(Estimate $estimate, $company_details)
    {
        $this->estimate = $estimate;
        $this->company_details = $company_details;
    }

    public function build()
    {
        $subject = config('app.name')." | Estimate #".$this->estimate->id;
        return $this
        ->subject($subject)
        ->markdown('crm.estimate.email.client');
    }
}
