<?php

namespace App\Jobs\Proposals;

use App\Models\Proposal;
use App\Mail\ProposalMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClientEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $proposal; 
    public $company_details; 
    public $to;
    public function __construct(Proposal $proposal, $company_details)
    {
        $this->proposal = $proposal;
        $this->company_details = $company_details;
        if($this->proposal->relation == 'Lead'){
            $this->to = $this->proposal->lead->email;
        }else{
            $this->to = $this->proposal->customer->first_contact->email;
        }
    }

    public function handle()
    {
        Mail::to($this->to)
        ->queue(new ProposalMail($this->proposal, $this->company_details));
    }
}
