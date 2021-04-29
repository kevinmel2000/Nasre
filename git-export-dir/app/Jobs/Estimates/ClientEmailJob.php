<?php

namespace App\Jobs\Estimates;

use App\Models\Estimate;
use App\Mail\EstimateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClientEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $estimate;
    public $company_details;

    public function __construct(Estimate $estimate, $company_details)
    {
        $this->estimate = $estimate;
        $this->company_details = $company_details;
    }

    public function handle()
    {
        
        Mail::to($this->estimate->customer->first_contact->email)
        ->queue(new EstimateMail($this->estimate, $this->company_details));
    }
}
