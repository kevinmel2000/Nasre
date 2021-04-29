<?php

namespace App\Mail;

use App\Models\Proposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProposalMail extends Mailable
{
    use Queueable, SerializesModels;
    public $proposal;
    public $company_details;
    public $products;
    public function __construct(Proposal $proposal, $company_details)
    {
        $this->proposal = $proposal;
        $this->company_details = $company_details;
    }

    public function build()
    {
        $subject = config('app.name')." | Proposal #".$this->proposal->id;
        return $this
        ->subject($subject)
        ->markdown('crm.proposal.email.client');
    }
}
