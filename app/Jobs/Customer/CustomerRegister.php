<?php

namespace App\Jobs\Customer;

use Illuminate\Bus\Queueable;
use App\Models\Customer\Customer;
use App\Mail\CustomerRegisterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomerRegister implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $customer; 
    public $company_details; 
    public $password;
    public function __construct(Customer $customer, $company_details, $password)
    {
        $this->customer = $customer;
        $this->company_details = $company_details;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->customer->first_contact->email)
        ->queue(new CustomerRegisterMail($this->customer, $this->company_details, $this->password));
    }
}
