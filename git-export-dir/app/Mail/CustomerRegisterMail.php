<?php

namespace App\Mail;

use App\Models\Customer\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $company_details;
    public $password;
    public function __construct(Customer $customer, $company_details, $password)
    {
        $this->customer = $customer;
        $this->company_details = $company_details;
        $this->password = $password;
    }

    public function build()
    {
        $subject = config('app.name')." | Customer ID #".$this->customer->id;
        return $this
        ->subject($subject)
        ->markdown('crm.customer.email.register');
    }
}
