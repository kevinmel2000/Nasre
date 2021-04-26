<?php

namespace App\Jobs\Client;

use App\Mail\ClientResetMail;
use Illuminate\Bus\Queueable;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $customer;
    public $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, $token)
    {
        $this->customer = $customer;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->customer->first_contact->email)
        ->queue(new ClientResetMail($this->customer, $this->token));
    }
}
